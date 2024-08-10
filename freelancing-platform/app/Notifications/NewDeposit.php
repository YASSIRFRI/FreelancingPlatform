<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;


class NewDeposit extends Notification
{
    use Queueable;

    protected $deposit;

    public function __construct($deposit)
    {
        $this->deposit = $deposit;
    }

    public function via($notifiable)
    {
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->deposit->user_id,
            'title' => 'New Deposit',
            'message' => 'A new deposit of $' . number_format($this->deposit->amount, 2) . ' has been made to your account.',
            'is_read' => false,
        ];
    }
}
