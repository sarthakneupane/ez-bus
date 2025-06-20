<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\VehicleHasRoute;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookedSeat;
use Illuminate\Support\Facades\DB;

class CompanyScheduleController extends Controller
{
    // Active schedules
public function index()
{
    $userId = auth()->id(); // Get the logged-in user's ID

    $schedules = Schedule::whereHas('vehicleHasRoute.vehicle.busCompany', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->with([
        'vehicleHasRoute.vehicle.busCompany',
        'vehicleHasRoute.route',
        'bookedSeats'
    ])
    ->whereIn('status', ['1', '2']) // Only show Active and On Journey
    ->get();

    return view('company.schedule.index', compact('schedules'));
}



    // Show create form
    public function create()
    {
        
$userId = auth()->id();

$vhrs = VehicleHasRoute::with('vehicle.busCompany', 'route')
    ->whereHas('vehicle.busCompany', function ($query) {
        $query->where('user_id', auth()->id());
    })
    ->get();

        return view('company.schedule.create', compact('vhrs'));
    }

    // Store new schedule
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_has_routes_id' => 'required|exists:vehicle_has_routes,id',
            'departure_date_time'   => 'required|date',
            'arrival_date_time'     => 'required|date|after:departure_date_time',
            // 'status'                => 'required|in:active,inactive',
        ]);
        $data['booked_seats'] = 0;
        Schedule::create($data);
        return redirect()->route('company.schedules')->with('success', 'Schedule created!');
    }

    // Show edit form
    public function edit(Schedule $schedule)
{
    $userId = auth()->id();

    $vhrs = VehicleHasRoute::with(['vehicle', 'route.fromLocation', 'route.toLocation'])
        ->whereHas('vehicle.busCompany', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

    return view('company.schedule.edit', compact('schedule', 'vhrs'));
}



    // Update existing schedule
    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'vehicle_has_routes_id' => 'required|exists:vehicle_has_routes,id',
            'departure_date_time'   => 'required|date',
            'arrival_date_time'     => 'required|date|after:departure_date_time',
            'status'                => 'required|in:0,1,2', // Accept Active, Inactive, On Journey
        ]);
        $schedule->update($data);

        if ($data['status'] == '0') {
            BookedSeat::where('schedule_id', $schedule->id)->delete();
        }

        return redirect()->route('company.schedules')->with('success', 'Schedule updated!');
    }


    // Inactive schedules history
    public function history()
{
    $userId = auth()->id(); // Logged-in user's ID

    $schedules = Schedule::whereHas('vehicleHasRoute.vehicle.busCompany', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->with([
        'vehicleHasRoute.vehicle.busCompany',
        'vehicleHasRoute.route'
    ])
    ->where('status', '0') // Completed schedules
    ->withCount('bookings')
    ->get();

    return view('company.schedule.history', compact('schedules'));
}


    public function showBookings($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
    
        $bookings = BookedSeat::with('user')
                    ->where('schedule_id', $schedule_id)
                    ->get();
    
        // Group bookings by user_id
        // $groupedBookings = $bookings->groupBy('user_id');
    
        return view('company.schedule.bookings', compact('schedule', 'bookings'));
    }

    // Show create booking form
    public function createBooking(Request $request)
    {
        $schedule_id = $request->schedule_id;
        return view('company.schedule.create-booking', compact('schedule_id'));
    }

public function storeBooking(Request $request)
{
    $validated = $request->validate([
        'schedule_id' => 'required|exists:schedules,id',
        'seat_no' => 'required|string|max:10',
        'boarding_point' => 'required|string|max:255',
        'passenger_name' => 'required|string|max:255',
        'passenger_phone' => 'required|string|max:255'
    ]);

    BookedSeat::create([
        'schedule_id' => $validated['schedule_id'],
        'seat_number' => $validated['seat_no'],
        'boarding_point' => $validated['boarding_point'],
        'passenger_name' => $validated['passenger_name'],
        'passenger_phone' => $validated['passenger_phone'],
        'status' => 1, // 1 = Active booking
    ]);

    return redirect()->route('company.schedules.bookings', $validated['schedule_id'])->with('success', 'Booking added successfully.');
}



}