<?php

namespace App\Listeners\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Events\Backend\NewOrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\Frontend\NewOrderInvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderInvoiceMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NewProductCreated  $event
     * @return void
     */
    public function handle(NewOrderPlaced $event)
    {
        Mail::to($event->customer)->send(new NewOrderInvoiceMail($event->order, $event->customer));
    }
}
