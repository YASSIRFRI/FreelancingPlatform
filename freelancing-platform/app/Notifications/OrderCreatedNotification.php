<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class OrderCreatedNotification extends Notification
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
            'title' => 'Order Created',
            'order_id' => $this->order->id,
            'message' => 'An order has been created for ' . $this->order->description . ' worth $' . number_format($this->order->amount, 2),
            'is_read' => false,
        ];
    }
}
