<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BusCompany;
use App\Models\Location;
use App\Models\Route;
    use App\Models\Booking;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


public function index()
{
    $usersCount = User::count();
    $busCompaniesCount = BusCompany::count();
    $locationsCount = Location::count();
    $routesCount = Route::count();

    // Bookings per day (last 7 days)
    $bookingsPerDay = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->whereDate('created_at', '>=', now()->subDays(6))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $topCompanies = DB::table('reviews')
    ->join('bookings', 'reviews.booking_id', '=', 'bookings.id')
    ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
    ->join('vehicle_has_routes', 'schedules.vehicle_has_routes_id', '=', 'vehicle_has_routes.id')
    ->join('vehicles', 'vehicle_has_routes.vehicle_id', '=', 'vehicles.id')
    ->join('bus_companies', 'vehicles.bus_company_id', '=', 'bus_companies.id')
    ->select(
        'bus_companies.bc_name as company_name',
        DB::raw('AVG(reviews.stars) as average_rating'),
        DB::raw('COUNT(reviews.id) as total_reviews')
    )
    ->groupBy('bus_companies.id', 'bus_companies.bc_name')
    ->orderByDesc('average_rating')
    ->limit(5)
    ->get();


    return view('admin.home', compact(
    'usersCount',
    'busCompaniesCount',
    'locationsCount',
    'routesCount',
    'bookingsPerDay',
    'topCompanies' 
));

}

}
