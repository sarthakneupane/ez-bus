<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $bookingId = $request->booking_id;

        $booking = Booking::with([
            'review',
            'schedule.vehicleHasRoutes.vehicle.busCompany',
            'schedule.vehicleHasRoutes.route.fromLocation',
            'schedule.vehicleHasRoutes.route.toLocation'
        ])->findOrFail($bookingId);

        // Authorization check
        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->review) {
            return redirect()->route('my.tickets')->with('error', 'You have already reviewed this booking.');
        }

        if (!($booking->status == 0 && $booking->schedule_status == 0)) {
            return redirect()->route('my.tickets')->with('error', 'You can only review completed bookings.');
        }
        

        return view('user.reviews.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'stars' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ]);

        // Verify booking belongs to user
        $booking = Booking::find($validated['booking_id']);
        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        Review::create($validated);

        return redirect()->route('my.tickets')->with('success', 'Review submitted successfully!');
    }

    public function show(Review $review)
{
    return view('user.reviews.show', compact('review'));
}

}