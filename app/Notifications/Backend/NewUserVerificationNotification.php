<?php

namespace App\Notifications\Backend;

use App\Models\Backend\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserVerificationNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(Lang::getFromJson('Hello '.$this->user->fname.'!'))
            ->subject(Lang::getFromJson('Verify Email Address'))
            ->line(
                "Welcome to ".config('app.name')." family."
            )
            ->line(
                'An admin account designated as role of '.$this->user->role->name.' has just been created for you.'
            )
            ->line(Lang::getFromJson('To verify your email address and to create your password please click the given link below.'))
            ->level('success')
            ->action(
                Lang::getFromJson('Verify Email Address'),
                $this->verificationUrl($notifiable)
                // route('verifyEmail', ['email' => $this->user->email, 'verify_token' => $this->user->verify_token])
            )
            ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));

    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'admin.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey(), 'verify_token' => $notifiable->verify_token]
        );
    }
    
}
