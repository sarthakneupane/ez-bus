<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSeat extends Model
{
    use HasFactory;

    protected $fillable = [
    'booking_id',
    'user_id',
    'schedule_id',
    'seat_number',
    'passenger_name', 
    'passenger_phone',
    'boarding_point'
];

    // BookedSeat.php
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');  // Assuming 'schedule_id' is the foreign key in the booked_seats table
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
