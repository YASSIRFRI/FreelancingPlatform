<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
    ];

    /**
     * Get the seller associated with the service.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the orders associated with the service.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'service_id');
    }

    /**
     * Get the reviews associated with the service.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id');
    }
}
