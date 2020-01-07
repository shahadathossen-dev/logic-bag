<?php

namespace App\Mail\Frontend;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Frontend\Customer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, Customer $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-order-invoice-email', ['order' => $this->order, 'notifiable' => $this->customer])->subject('New Order Invoice');
    }
}
