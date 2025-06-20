<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function search(Request $request)
{
    $request->validate([
        'from_loc' => 'required|string',
        'to_loc'   => 'required|string',
        'dep_date' => 'required|date',
    ]);

    // Get route based on from and to location
    $route = Route::whereHas('fromLocation', fn($q) => $q->where('name', $request->from_loc))
                  ->whereHas('toLocation', fn($q) => $q->where('name', $request->to_loc))
                  ->first();

    if (! $route) {
        return back()->with('error', 'No route found for the selected locations.');
    }

    // Fetch schedules with related data
    $schedules = Schedule::with([
            'vehicleHasRoute.vehicle.busCompany',
            'vehicleHasRoute.vehicle.seatFormat',
            'vehicleHasRoute.route.fromLocation',
            'vehicleHasRoute.route.toLocation',
        ])
        ->whereHas('vehicleHasRoute.route', fn($q) => $q->where('id', $route->id))
        ->whereDate('departure_date_time', $request->dep_date)
        ->where('status', '1')
        ->get();

    // Get all vehicle IDs from the schedules
    $vehicleIds = $schedules->pluck('vehicleHasRoute.vehicle.id')->unique();

    // Preload all reviews for these vehicles
    $vehicleReviews = DB::table('reviews')
        ->select(
            'vehicles.id as vehicle_id',
            DB::raw('AVG(reviews.stars) as avg_rating'),
            DB::raw('COUNT(reviews.id) as review_count')
        )
        ->join('bookings', 'bookings.id', '=', 'reviews.booking_id')
        ->join('schedules', 'schedules.id', '=', 'bookings.schedule_id')
        ->join('vehicle_has_routes', 'vehicle_has_routes.id', '=', 'schedules.vehicle_has_routes_id')
        ->join('vehicles', 'vehicles.id', '=', 'vehicle_has_routes.vehicle_id')
        ->whereIn('vehicles.id', $vehicleIds)
        ->groupBy('vehicles.id')
        ->get()
        ->keyBy('vehicle_id');

    foreach ($schedules as $schedule) {
        $vhr = $schedule->vehicleHasRoute;
        $vehicle = $vhr->vehicle;

        // Step 1: Get total seats
        $seatFormat = $vehicle->seatFormat;
        $totalSeats = ($seatFormat->column_left + $seatFormat->column_right) * $seatFormat->rows;

        // Step 2: Get booked seat count
        $bookedSeats = DB::table('booked_seats')
            ->where('schedule_id', $schedule->id)
            ->count();

        // Step 3: Calculate available seats
        $schedule->available_seats = $totalSeats - $bookedSeats;
        $schedule->total_seats = $totalSeats;

        // Step 4: Fare calculation
        $baseFare = $vhr->route->fare ?? 0;
        $fareIncrement = DB::table('vehicle_type_class')
            ->where('vehicle_type_id', $vehicle->vehicle_type_id)
            ->where('vehicle_class_id', $vehicle->vehicle_class_id)
            ->value('fare_increment') ?? 0;

        $schedule->computed_fare = round($baseFare + ($baseFare * $fareIncrement / 100), 2);

        // Step 5: Get vehicle rating from preloaded data
        $vehicleRating = $vehicleReviews[$vehicle->id] ?? null;
        
        $schedule->average_stars = $vehicleRating ? round($vehicleRating->avg_rating, 1) : null;
        $schedule->review_count = $vehicleRating ? $vehicleRating->review_count : 0;
    }

    return view('buslist', compact('schedules'));
}
}
