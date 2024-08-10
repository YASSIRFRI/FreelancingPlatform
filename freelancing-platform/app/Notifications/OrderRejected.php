<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class OrderRejected extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->order->buyer_id,
            'title' => 'Order Rejected',
            'order_id' => $this->order->id,
            'message' => 'Your order for ' . $this->order->description . ' has been rejected.',
            'is_read' => false,
        ];
    }
}
