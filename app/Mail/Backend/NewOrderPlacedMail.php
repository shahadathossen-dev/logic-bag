<?php

namespace App\Mail\Backend;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $notifiable)
    {
        $this->order = $order;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.new-order-email', ['order' => $this->order, 'notifiable' => $this->notifiable])->subject('New Order from '.config('app.name'));
    }
}
