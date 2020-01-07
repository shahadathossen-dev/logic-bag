<?php

namespace App\Notifications\Backend;

use App\Models\Backend\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserCreatedNotification extends Notification
{
    use Queueable;

    public $user;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            route('admin.user.details', ["id" =>$this->user->id]),
        ];
    }

    // public function toDatabase($notifiable)
    // {
    //     return [
            
    //     ];
    // }
}
