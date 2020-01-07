<?php

namespace App\Notifications\Backend;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use App\Models\Product\Review;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewProductReviewNotification extends Notification
{
    use Queueable;

    protected $review;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
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
            route('admin.review.details', ['review' => $this->review->id]),
        ];
    }
}
