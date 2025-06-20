<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    // Specify the table name if it's not automatically inferred
    protected $table = 'vehicle_types';

    // Define the mass-assignable fields
    protected $fillable = [
        'name',
    ];
}
