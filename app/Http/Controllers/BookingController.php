<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location; // Import the Location model
use App\Models\Schedule;
use App\Models\BookedSeat;
use App\Models\Booking;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Seat;
use App\Models\SeatFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{

public function welcome()
{
    $locations = Location::all(); 
    return view('welcome', compact('locations')); 
}
public function index()
{
    return view('user.booking.index');  
}



public function seatLayoutPartial(Schedule $schedule)
{
    $bookedSeats = BookedSeat::where('schedule_id', $schedule->id)
        ->pluck('seat_number')
        ->toArray();

    $vehicle = $schedule->vehicleHasRoute->vehicle;
    $seatFormat = $vehicle->seatFormat;

    $columnLeft = $seatFormat->column_left;
    $columnRight = $seatFormat->column_right;
    $rows = $seatFormat->rows;

    $seats = [];
    $aCount = 1;
    $bCount = 1;

    for ($r = 0; $r < $rows; $r++) {
        $row = [];

        for ($c = 0; $c < $columnLeft; $c++) {
            $seat = 'A' . $aCount++;
            $row[] = [
                'number' => $seat,
                'booked' => in_array($seat, $bookedSeats),
            ];
        }

        $row[] = null;

        for ($c = 0; $c < $columnRight; $c++) {
            $seat = 'B' . $bCount++;
            $row[] = [
                'number' => $seat,
                'booked' => in_array($seat, $bookedSeats),
            ];
        }

        $seats[] = $row;
    }

    return view('layouts.partials.seatlayout', compact('seats'));
}

// In the controller (store method)
public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seats' => 'required|string',
            'price' => 'required|numeric',
            'passenger_id' => 'required|exists:users,id',
        ]);

        session([
            'booking_data' => $request->only(['schedule_id', 'seats', 'price', 'passenger_id']),
        ]);

        return redirect()->route('booking.details');
    }
public function details()
    {
        $data = session('booking_data');

        if (!$data) {
            return redirect('/')->with('error', 'Missing booking data.');
        }

        $seats = explode(',', $data['seats']);
        $schedule = Schedule::findOrFail($data['schedule_id']);

        return view('user.booking.details', [
            'seats' => $seats,
            'schedule' => $schedule,
            'price' => $data['price'],
        ]);
    }

public function storedetails(Request $request)
{
    $data = session('booking_data');

    if (!$data) {
        return redirect('/')->with('error', 'Session expired or missing booking data.');
    }

    $request->validate([
        'seats' => 'required|array',
        'details' => 'required|array',
        'details.*.name' => 'required|string',
        'details.*.phone' => 'required|string',
        'details.*.boarding_point' => 'required|string',
        'details.*.seat' => 'required|string',
    ]);

    session([
        'passenger_details' => $request->input('details'),
        'seats' => $request->input('seats'),
    ]);

    return redirect()->route('payment.request');
}
public function paymentRequest()
{
    // dd('Test - Reached paymentRequest()');
    $data = session('booking_data');
    $seats = session('seats');
    $total = count($seats) * $data['price'];

    return view('user.booking.payment', [
        'total' => $total,
        'booking_data' => $data,
    ]);
}
public function paymentSuccess(Request $request)
{
    $data = session('booking_data');
    $details = session('passenger_details');
    $seats = session('seats');

    if (!$data || !$details || !$seats) {
        return redirect('/')->with('error', 'Session expired.');
    }

    $total = count($seats) * $data['price'];

    DB::beginTransaction();
    try {
        $booking = Booking::create([
            'passenger_id' => $data['passenger_id'],
            'schedule_id' => $data['schedule_id'],
            'seats' => count($seats),
            'price' => $data['price'],
            'total' => $total,
        ]);

        foreach ($details as $detail) {
            BookedSeat::create([
                'user_id' => $data['passenger_id'],
                'schedule_id' => $data['schedule_id'],
                'seat_number' => $detail['seat'],
                'passenger_name' => $detail['name'],
                'passenger_phone' => $detail['phone'],
                'boarding_point' => $detail['boarding_point'],
            ]);
        }

        Mail::to($booking->user->email)->send(new TicketMail($booking));
        DB::commit();
        session()->forget('booking_data');
        session()->forget('passenger_details');
        session()->forget('seats');

        return redirect()->route('booking.success')->with('success', 'Booking and payment successful!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Booking storing after eSewa failed: ' . $e->getMessage());
        return redirect()->route('payment.fail')->with('error', 'Something went wrong.');
    }
}
public function paymentFail()
{
    return redirect('/')->with('error', 'Payment failed. Please try again.');
}


    public function success()
    {
        return view('user.booking.success');
    }
}






