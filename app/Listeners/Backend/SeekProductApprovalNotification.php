<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Backend\NewProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewProductCreatedNotification;

class SeekProductApprovalNotification
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
    public function handle(NewProductCreated $event)
    {
        $this->notifiable = User::where('role_id', 1)->get();

        foreach ($this->notifiable as $user) {

            $user->notify(new NewProductCreatedNotification($event->product));

        }
    }
}
