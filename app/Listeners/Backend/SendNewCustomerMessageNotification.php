<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use App\Models\Product\Message;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Frontend\NewCustomerMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewCustomerMessageNotification;

class SendNewCustomerMessageNotification 
{
    public $notifiable;

    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Handle the event.
     *
     * @param  NewProductReviewed  $event
     * @return void
     */
    public function handle(NewCustomerMessage $event)
    {
        $this->notifiable = User::where('role_id', [4])->get();
        foreach ($this->notifiable as $user) {
            $user->notify(new NewCustomerMessageNotification($event->message));
        }
    }
}
