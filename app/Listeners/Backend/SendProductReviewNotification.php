<?php

namespace App\Listeners\Backend;

use App\Models\Backend\User;
use App\Models\Product\Review;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Frontend\NewProductReview;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Backend\NewProductReviewNotification;

class SendProductReviewNotification 
{
    public $notifiable;

    public $review;
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
     * Handle the event.
     *
     * @param  NewProductReviewed  $event
     * @return void
     */
    public function handle(NewProductReview $event)
    {
        $this->notifiable = User::where('role_id', [4])->get();
        foreach ($this->notifiable as $user) {
            $user->notify(new NewProductReviewNotification($event->review));
        }
    }
}
