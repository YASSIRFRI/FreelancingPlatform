<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'description',
        'profile_picture', // Correcting spelling here from 'profil_picture' to 'profile_picture'
        'balance'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified' => 'boolean',
    ];

    /**
     * Get all the deposits for the user.
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    /**
     * Get all the withdrawals for the user.
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
