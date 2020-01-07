<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Frontend\NewCustomerRegistered;
use App\Notifications\Backend\NewCustomerRegisteredNotification;

class SendNewCustomerRegisteredNotification
{
    public $notifiable;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  New CustomerCreated  $event
     * @return void
     */
    public function handle(NewCustomerRegistered $event)
    {
        $this->notifiable = User::where('role_id', [2])->get();

        foreach ($this->notifiable as $user) {
            $user->notify(new NewCustomerRegisteredNotification($event->customer));
        }
    }
}
