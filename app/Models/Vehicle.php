<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class Vehicle extends Model
{
    use HasFactory, SoftDeletes; 

    // Allow mass assignment for these fields
    protected $fillable = [
        'bus_company_id',
        'vehicle_no',
        'vehicle_type_id',
        'vehicle_class_id',
        'seats',
        'amenities',
        'seat_formats_id', 
        'registration_pdf',
        'image',
    ];

    // Define relationships
    public function busCompany()
    {
        return $this->belongsTo(BusCompany::class, 'bus_company_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function vehicleClass()
    {
        return $this->belongsTo(VehicleClass::class, 'vehicle_class_id');
    }

    public function seatFormat()
    {
        return $this->belongsTo(SeatFormat::class, 'seat_formats_id');
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class, 'vehicle_has_routes')
                    ->using(VehicleHasRoute::class)
                    ->withTimestamps()
                    ->withPivot('deleted_at')
                    ->wherePivotNull('deleted_at');  // only non-soft deleted
    }



    // Get the fare increment (%) for this vehicle’s type+class combo:
    public function getFareIncrementAttribute()
    {
        return VehicleTypeClass::where('vehicle_type_id', $this->vehicle_type_id)
            ->where('vehicle_class_id', $this->vehicle_class_id)
            ->value('fare_increment') ?? 0;
    }

    // Compute adjusted fare for a given route:
    public function adjustedFare(\App\Models\Route $route)
    {
        $increment = $this->fare_increment;
        return $route->fare * (1 + $increment / 100);
    }

    public function bookings()
{
    return $this->hasManyThrough(
        \App\Models\Booking::class,
        \App\Models\Schedule::class,
        'vehicle_has_routes_id',
        'schedule_id',
        'id',
        'id'
    );
}

public function reviews()
{
    return $this->hasManyThrough(
        \App\Models\Review::class,
        \App\Models\Booking::class,
        'schedule_id',
        'booking_id',
        'id',
        'id'
    );
}

}
