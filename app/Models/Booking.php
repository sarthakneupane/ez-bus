<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // If you need to specify the table name (optional, Laravel uses plural by default)
    protected $table = 'bookings'; 

    // Define the fillable attributes (columns) in the bookings table
    protected $fillable = [
        'passenger_id',
        'schedule_id',
        'seats',
        'price',
        'total',
        'status',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function vehicleHasRoutes()
    {
        return $this->belongsTo(VehicleHasRoute::class);
    }
    public function bookedSeats()
    {
        return $this->hasMany(BookedSeat::class, 'booking_id'); // Assuming 'booking_id' is the foreign key in booked_seats table
    }

    public function review()
{
    return $this->hasOne(Review::class);
}

public function user()
{
    return $this->belongsTo(User::class, 'passenger_id');
}


}
