<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusCompany extends Model
{
    use HasFactory;

    // Specify the table name if it's not automatically inferred
    protected $table = 'bus_companies';

    // Define which fields are mass assignable
    protected $fillable = [
        'user_id',
        'bc_name',
        'no_of_bus',
        'status', // Assuming you want to store the status as well
        'company_registration',
        'cover_letter',
    ];

    public function vehicles()
{
    return $this->hasMany(Vehicle::class, 'bus_company_id'); // use correct foreign key if different
}
public function reviews()
{
    return $this->hasManyThrough(
        \App\Models\Review::class,
        \App\Models\Booking::class,
        'user_id', // not needed here; we'll handle it manually via vehicle relation
        'booking_id'
    );
}

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
