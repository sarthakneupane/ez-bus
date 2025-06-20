<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use App\Models\BookedSeat;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $passenger;
    public $bookedSeats;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking->load([
            'user', 
            'schedule.vehicleHasRoute.vehicle.busCompany',
            'schedule.vehicleHasRoute.route.fromLocation',
            'schedule.vehicleHasRoute.route.toLocation'
        ]);
        
        $this->passenger = $booking->user;
        $this->bookedSeats = BookedSeat::where('schedule_id', $booking->schedule_id)
                                      ->where('user_id', $booking->passenger_id)
                                      ->get();
    }

    public function build()
    {
        $pdf = Pdf::loadView('user.ticket_pdf', [
            'booking' => $this->booking,
            'passenger' => $this->passenger,
            'bookedSeats' => $this->bookedSeats
        ]);

        return $this->subject('Your EzBus Ticket')
                   ->markdown('emails.ticket')
                   ->attachData($pdf->output(), 'ticket.pdf', [
                       'mime' => 'application/pdf',
                   ]);
    }
}