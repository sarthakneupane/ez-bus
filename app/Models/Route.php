<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ Add this

class Route extends Model
{
    use HasFactory, SoftDeletes; // ✅ Enable soft deletes

    protected $fillable = ['name', 'from', 'to', 'fare'];

    public function fares()
    {
        return $this->hasMany(Fare::class, 'route_id');
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to');
    }
}
