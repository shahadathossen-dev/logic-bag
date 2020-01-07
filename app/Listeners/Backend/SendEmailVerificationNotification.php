<?php

namespace App\Listeners\Backend;

use App\Events\Backend\NewUserApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewUserVerificationNotification;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(NewUserApproved $event)
    {
        $event->user->notify(new NewUserVerificationNotification($event->user));
    }
}
