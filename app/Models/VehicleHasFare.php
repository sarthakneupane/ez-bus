<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleHasFare extends Model
{

    public $timestamps = false; // 🚨 Disable timestamps to avoid errors

    protected $table = 'vehicle_has_fares';  // Update if your table name is different

    protected $fillable = ['vehicle_id', 'route_id', 'fare'];  // Fill with relevant columns in your table

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // In App\Models\VehicleHasFare.php

public function fare()
{
    return $this->belongsTo(Fare::class, 'fare_id');
}


}
