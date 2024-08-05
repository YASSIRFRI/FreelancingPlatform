<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'service_id',
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

    /**
     * Get the service associated with the review.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
