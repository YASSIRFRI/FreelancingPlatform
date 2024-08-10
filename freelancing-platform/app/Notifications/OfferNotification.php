<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class OfferNotification extends Notification
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

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->offer->seller_id,
            'title' => 'New Offer Received',
            'message' => 'You have received a new offer for ' . $this->offer->description . ' worth $' . number_format($this->offer->amount, 2),
            'is_read' => false,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->offer->seller_id,
            'title' => 'New Offer Received',
            'message' => 'You have received a new offer for ' . $this->offer->description . ' worth $' . number_format($this->offer->amount, 2),
            'is_read' => false,
        ];
    }
}
