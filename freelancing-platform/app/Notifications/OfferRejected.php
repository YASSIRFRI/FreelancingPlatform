<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class OfferRejected extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->offer->buyer_id,
            'title' => 'Offer Rejected',
            'message' => 'Your offer for ' . $this->offer->description . ' has been rejected.',
            'is_read' => false,
        ];
    }
}
