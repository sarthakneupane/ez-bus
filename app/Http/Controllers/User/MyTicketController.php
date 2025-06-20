<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookedSeat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyTicketController extends Controller
{
public function index()
{


$bookings = Booking::with([
        'schedule.vehicleHasRoutes.route.fromLocation',
        'schedule.vehicleHasRoutes.route.toLocation',
        'schedule.vehicleHasRoutes.vehicle' => function ($query) {
            $query->withTrashed(); // Include soft-deleted vehicles
        },
        'schedule.vehicleHasRoutes.vehicle.busCompany',
        'review'
    ])
    ->where('passenger_id', auth()->id())
    ->orderBy('created_at', 'desc')
    ->get()
    ->map(function ($booking) {
        return (object) [
            'id' => $booking->id,
            'status' => $booking->status,
            'seats' => $booking->seats,
            'price' => $booking->price,
            'departure_date_time' => optional($booking->schedule)->departure_date_time,
            'vehicle_no' => optional(optional(optional($booking->schedule)->vehicleHasRoutes)->vehicle)->vehicle_no,
            'bus_company_name' => optional(optional(optional($booking->schedule)->vehicleHasRoutes)->vehicle)->busCompany->bc_name ?? '',
            'from' => optional(optional($booking->schedule->vehicleHasRoutes->route ?? null)->fromLocation)->name,
            'to' => optional(optional($booking->schedule->vehicleHasRoutes->route ?? null)->toLocation)->name,
            'review' => $booking->review,
            'schedule_status' => optional($booking->schedule)->status
        ];
    });


    return view('user.my_tickets', compact('bookings'));
}



   public function cancel($id)
{
    DB::transaction(function () use ($id) {
        $booking = Booking::with('schedule')->findOrFail($id);

        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if departure is within 24 hours
        $departureTime = \Carbon\Carbon::parse($booking->schedule->departure_date_time);
        $now = \Carbon\Carbon::now();
        
        if ($now->diffInHours($departureTime, false) < 24) {
            return redirect()->back()->with('error', 'Ticket can only be cancelled at least 24 hours before departure.');
        }

        if ($booking->status == 0) {
            BookedSeat::where([
                'user_id' => auth()->id(),
                'schedule_id' => $booking->schedule_id,
            ])->delete();

            $booking->status = '1'; // 1 = cancelled
            $booking->save();

            $refundAmount = $booking->price * $booking->seats * 0.8;

            DB::table('wallets')->where('user_id', auth()->id())
                ->increment('balance', $refundAmount);

            $companyUserId = $booking->schedule->vehicleHasRoutes->vehicle->busCompany->user_id;

            DB::table('wallets')->where('user_id', $companyUserId)
                ->decrement('balance', $refundAmount);
        }
    });

    return redirect()->back()->with('success', 'Booking cancelled. 80% refund processed.');
}
   public function generatePdf($id)
{
    $booking = Booking::with([
            'schedule.vehicleHasRoutes.route.fromLocation',
            'schedule.vehicleHasRoutes.route.toLocation',
            'schedule.vehicleHasRoutes.vehicle.busCompany',
        ])
        ->findOrFail($id);

    if ($booking->passenger_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $bookedSeats = BookedSeat::where('schedule_id', $booking->schedule_id)
        ->where('user_id', auth()->id())
        ->get();

    $passenger = auth()->user();

    // Generate QR code data - more compact format for better scanning
    $qrContent = json_encode([
        'ticket_id' => $booking->id,
        'passenger' => $passenger->name,
        'contact' => $passenger->phone,
        'route' => $booking->schedule->vehicleHasRoutes->route->fromLocation->name.'-'.
                   $booking->schedule->vehicleHasRoutes->route->toLocation->name,
        'departure' => \Carbon\Carbon::parse($booking->schedule->departure_date_time)->format('YmdHi'),
        'seats' => $bookedSeats->pluck('seat_number')->implode(','),
        'bus' => $booking->schedule->vehicleHasRoutes->vehicle->vehicle_no
    ]);

    // Generate QR code image using Simple QrCode package
    // $qrCode = QrCode::format('png')
    //             ->size(200)
    //             ->errorCorrection('H') 
    //             ->generate($qrContent);

    // Convert to base64 for embedding in PDF
    // $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCode);

    $pdf = Pdf::loadView('user.ticket_pdf', [
        'booking' => $booking,
        'bookedSeats' => $bookedSeats,
        'passenger' => $passenger,
        // 'qrCodeImage' => $qrCodeBase64
    ]);

    return $pdf->stream('ticket_'.$booking->id.'.pdf');
}
}
