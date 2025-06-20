<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatFormat extends Model
{
    protected $fillable = ['column_left', 'column_right', 'rows'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'seat_formats_id');
    }
}
