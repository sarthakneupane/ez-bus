<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPassword;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 0;
    const ROLE_BUS_COMPANY = 1;
    const ROLE_PASSENGER = 2;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role'
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function busCompany()
    {
        return $this->hasOne(BusCompany::class, 'user_id');
    }

    public function wallet()
{
    return $this->hasOne(Wallet::class);
}

public function sendEmailVerificationNotification()
{
    $this->notify(new CustomVerifyEmail);
}



public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPassword($token, $this->email));
}


    
}
