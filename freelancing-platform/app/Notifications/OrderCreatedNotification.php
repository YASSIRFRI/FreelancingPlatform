<?php

// app/Notifications/OrderCreatedNotification.php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send via email and store in database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order Received')
                    ->line('You have received a new order.')
                    ->action('View Order', route('orders.show', $this->order->id))
                    ->line('Thank you for using our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'buyer_name' => $this->order->buyer->name,
            'service_name' => $this->order->service->name,
        ];
    }
}
