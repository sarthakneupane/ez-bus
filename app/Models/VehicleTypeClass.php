<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTypeClass extends Model
{
    use HasFactory;

    protected $table = 'vehicle_type_class';
    protected $fillable = ['vehicle_type_id', 'vehicle_class_id', 'fare_increment'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function vehicleClass()
    {
        return $this->belongsTo(VehicleClass::class, 'vehicle_class_id');
    }
}

