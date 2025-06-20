<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleClass extends Model
{
    use HasFactory;

    // Define the mass-assignable fields
    protected $fillable = [
        'name',
    ];
}
