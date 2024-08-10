<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OfferAccepted extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->offer->buyer_id,
            'title' => 'Offer Accepted',
            'message' => 'Your offer for ' . $this->offer->description . ' has been accepted.',
            'is_read' => false,
        ];
    }
}
