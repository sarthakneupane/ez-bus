<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleHasRoute;
use App\Models\VehicleTypeClass;

class Schedule extends Model
{
    protected $fillable = [
        'vehicle_has_routes_id',
        'departure_date_time',
        'arrival_date_time',
        'status',
        'booked_seats'
    ];

    // Always include computed_fare in JSON / array casts
    protected $appends = ['computed_fare'];

    public function vehicleHasRoute()
    {
        return $this->belongsTo(VehicleHasRoute::class, 'vehicle_has_routes_id');
    }

    public function getComputedFareAttribute()
    {
        $vhr = $this->vehicleHasRoute;
    
        // Make sure the vehicle and route are available
        if (! $vhr || ! $vhr->vehicle || ! $vhr->route) {
            return 0;
        }
    
        $route  = $vhr->route;
        $vehicle = $vhr->vehicle;
    
        $baseFare = $route->fare ?? 0;
    
        // Get the fare increment from vehicle_type_class table
        $vtc = VehicleTypeClass::where('vehicle_type_id',  $vehicle->vehicle_type_id)
                                           ->where('vehicle_class_id', $vehicle->vehicle_class_id)
                                           ->first();
    
        $increment = $vtc ? $vtc->fare_increment : 0;
    
        $totalFare = (($increment / 100) * $baseFare) + $baseFare;
    
        return round($totalFare, 2);
    }


public function bookedSeats()
{
    return $this->hasMany(BookedSeat::class, 'schedule_id');  // Assuming 'schedule_id' is the foreign key in booked_seats table
}

public function vehicleHasRoutes()
    {
        return $this->belongsTo(VehicleHasRoute::class);
    }

    public function bookings()
{
    return $this->hasMany(\App\Models\Booking::class);
}

}



