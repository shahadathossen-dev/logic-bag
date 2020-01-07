<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\Backend\SeekApprovalNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\Backend\NewUserCreated' => [
            'App\Listeners\Backend\SeekApprovalNotification',
        ],

        'App\Events\Backend\NewUserApproved' => [
            'App\Listeners\Backend\SendEmailVerificationNotification',
        ],

        'App\Events\Backend\NewProductCreated' => [
            'App\Listeners\Backend\SeekProductApprovalNotification',
        ],
        
        'App\Events\Frontend\NewCustomerRegistered' => [
            'App\Listeners\Frontend\SendWelcomeMail',
            // 'App\Listeners\Backend\SendNewCustomerRegisteredNotification',
        ],

        'App\Events\Frontend\NewProductReview' => [
            'App\Listeners\Backend\SendProductReviewNotification',
        ],

        'App\Events\Backend\NewOrderPlaced' => [
            'App\Listeners\Backend\SendNewOrderNotification',
            'App\Listeners\Frontend\SendNewOrderInvoiceMail',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
