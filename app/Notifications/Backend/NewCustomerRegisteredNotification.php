<?php

namespace App\Notifications\Backend;

use Illuminate\Bus\Queueable;
use App\Models\Frontend\Customer;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCustomerRegisteredNotification extends Notification
{
    use Queueable;

    protected $customer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            route('admin.customer.details', ["id" => $this->customer->id]),
        ];
    }
}
