<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\CustomDatabaseChannel;

class NewWithdrawal extends Notification
{
    use Queueable;

    protected $withdrawal;

    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function via($notifiable)
    {
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->withdrawal->user_id,
            'title' => 'New Withdrawal',
            'message' => 'A new withdrawal of $' . number_format($this->withdrawal->amount, 2) . ' has been made from your account.',
            'is_read' => false,
        ];
    }
}
