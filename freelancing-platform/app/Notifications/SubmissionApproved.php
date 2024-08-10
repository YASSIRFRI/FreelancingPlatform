<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class SubmissionApproved extends Notification
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
            'order_id' => $this->order->id,
            'title' => 'Submission Approved',
            'message' => 'Your submission for ' . $this->order->description . ' has been approved.',
            'is_read' => false,
        ];
    }
}

