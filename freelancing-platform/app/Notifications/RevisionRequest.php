<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class RevisionRequest extends Notification
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
            'user_id' => $this->order->seller_id,
            'title' => 'Revision Requested',
            'message' => 'A revision has been requested for your order: ' . $this->order->description,
            'is_read' => false,
        ];
    }
}
