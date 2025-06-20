<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class VehicleHasRoute extends Pivot
{
    use SoftDeletes;

    protected $table = 'vehicle_has_routes'; 

    protected $fillable = [
        'vehicle_id',
        'route_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'vehicle_has_routes_id');
    }
}
