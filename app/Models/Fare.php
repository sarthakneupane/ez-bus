<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    use HasFactory;

    // protected $table = 'fare';
    // protected $fillable = ['vehicle_type_class_id', 'route_id', 'fare_amount'];

    // public function vehicleHasFares()
    // {
    //     return $this->hasMany(VehicleHasFare::class);
    // }

    // public function route()
    // {
    //     return $this->belongsTo(Route::class, 'route_id');
    // }

    // public function vehicleTypeClass()
    // {
    //     return $this->belongsTo(VehicleTypeClass::class, 'vehicle_type_class_id');
    // }
}
