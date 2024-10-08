<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'stars',
        'comment',
    ];

    /**
     * Get the buyer associated with the review.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


}
