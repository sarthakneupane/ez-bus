<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
   
       use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\VehicleHasRoute;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index()
{
    $userId = Auth::id();

    $busCompanyId = DB::table('bus_companies')->where('user_id', $userId)->value('id');

    // Daily bookings (last 1 week)
    $bookings = DB::table('bookings')
        ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
        ->join('vehicle_has_routes', 'schedules.vehicle_has_routes_id', '=', 'vehicle_has_routes.id')
        ->join('vehicles', 'vehicle_has_routes.vehicle_id', '=', 'vehicles.id')
        ->join('bus_companies', 'vehicles.bus_company_id', '=', 'bus_companies.id')
        ->where('bus_companies.user_id', $userId)
        ->whereBetween('bookings.created_at', [now()->subDays(7)->startOfDay(), now()])
        ->select(DB::raw("DATE(bookings.created_at) as date"), DB::raw("COUNT(*) as count"))
        ->groupBy('date')
        ->orderBy('date', 'asc') 
        ->get();

    $bookingDates = $bookings->pluck('date');
    $bookingCounts = $bookings->pluck('count');

    // Vehicle Types (e.g. Micro, Bus, etc.)
    $vehicleTypes = Vehicle::whereHas('busCompany', fn($q) => $q->where('user_id', $userId))
        ->select('vehicle_type_id', DB::raw('count(*) as total'))
        ->groupBy('vehicle_type_id')
        ->pluck('total', 'vehicle_type_id');

    // Route-wise schedule count
    $routes = DB::table('schedules')
        ->join('vehicle_has_routes', 'schedules.vehicle_has_routes_id', '=', 'vehicle_has_routes.id')
        ->join('vehicles', 'vehicle_has_routes.vehicle_id', '=', 'vehicles.id')
        ->join('routes', 'vehicle_has_routes.route_id', '=', 'routes.id')
        ->join('locations as from_l', 'routes.from', '=', 'from_l.id')
        ->join('locations as to_l', 'routes.to', '=', 'to_l.id')
        ->join('bus_companies', 'vehicles.bus_company_id', '=', 'bus_companies.id')
        ->where('bus_companies.user_id', $userId)
        ->where('schedules.departure_date_time', '>=', now())
        ->select(
            DB::raw("CONCAT(from_l.name, ' → ', to_l.name) as route_name"),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('route_name')
        ->get();

    $routeNames = $routes->pluck('route_name');
    $scheduleCountsByRoute = $routes->pluck('total');

    // Reuse your existing counts
    $vehicleCount = Vehicle::whereHas('busCompany', fn($q) => $q->where('user_id', $userId))->count();
    $routeCount = VehicleHasRoute::whereHas('vehicle.busCompany', fn($q) => $q->where('user_id', $userId))->count();
    $scheduleCount = Schedule::whereHas('vehicleHasRoute.vehicle.busCompany', fn($q) => $q->where('user_id', $userId))->where('departure_date_time', '>=', now())->count();
    $bookingCount = Booking::whereHas('schedule.vehicleHasRoute.vehicle.busCompany', fn($q) => $q->where('user_id', $userId))->count();

    // Count vehicles by type (for graph)
    $vehicleCountsByType = Vehicle::where('bus_company_id', $busCompanyId)
        ->join('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.id')
        ->select('vehicle_types.name as type', DB::raw('count(*) as total'))
        ->groupBy('vehicle_types.name')
        ->get();

    return view('company.dashboard', compact(
        'vehicleCount',
        'routeCount',
        'scheduleCount',
        'bookingCount',
        'bookingDates', // Updated with daily bookings
        'bookingCounts', // Updated with daily bookings
        'vehicleTypes',
        'vehicleCountsByType',
        'routeNames',
        'scheduleCountsByRoute'
    ));
}


    
    
}
