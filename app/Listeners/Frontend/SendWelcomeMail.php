<?php

namespace App\Listeners\Frontend;

use App\Models\Frontend\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Frontend\NewCustomerWelcomeMail;
use App\Events\Frontend\NewCustomerRegistered;
use App\Notifications\Frontend\NewCustomerWelcomeNotification;

class SendWelcomeMail
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NewCustomerRegistered  $event
     * @return void
     */
    // public function handle(NewCustomerRegistered $event)
    // {
    //     $event->customer->notify(new NewCustomerWelcomeMail($event->customer));
    // }

    public function handle(NewCustomerRegistered $event)
    {
        Mail::to($event->customer)->send(new NewCustomerWelcomeMail($event->customer));
        // $event->customer->notify(new NewCustomerWelcomeMail($event->customer));
    }
}
