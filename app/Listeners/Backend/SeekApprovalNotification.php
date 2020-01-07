<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use App\Events\Backend\NewUserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewUserCreatedNotification;

class SeekApprovalNotification
{
    public $notifiable;
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
    public function handle(NewUserCreated $event)
    {
        $this->notifiable = User::findOrFail(1);
        $this->notifiable->notify(new NewUserCreatedNotification($event->user));
    }
}
