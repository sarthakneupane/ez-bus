<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 👈 Import this

class Location extends Model
{
    use HasFactory, SoftDeletes; // 👈 Add SoftDeletes trait

    protected $table = 'locations';

    protected $fillable = ['name'];

    // Optional: If you want to treat `deleted_at` as a Carbon date instance (optional in Laravel 9+)
    protected $dates = ['deleted_at'];

public function fromLocation()
{
    return $this->belongsTo(Location::class, 'from');
}

public function toLocation()
{
    return $this->belongsTo(Location::class, 'to');
}

}
