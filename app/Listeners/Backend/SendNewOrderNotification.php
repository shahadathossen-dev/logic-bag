<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use App\Events\Backend\NewOrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewOrderNotification;

class SendNewOrderNotification
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
     * @param  NewProductCreated  $event
     * @return void
     */
    public function handle(NewOrderPlaced $event)
    {
        $this->notifiable = User::where('role_id', [1, 2, 5])->get();

        foreach ($this->notifiable as $user) {
            $user->notify(new NewOrderNotification($event->order));
        }
    }
}
