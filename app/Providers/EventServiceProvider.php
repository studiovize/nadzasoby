<?php

namespace App\Providers;

use App\Events\CreditAdded;
use App\Events\CreditExpired;
use App\Events\CreditReminder;
use App\Events\CreditSpent;
use App\Events\ListingApproved;
use App\Events\ListingCreated;
use App\Events\ListingUpdated;
use App\Events\ListingRejected;
use App\Events\MessageReceived;
use App\Events\PaymentError;
use App\Events\PaymentSuccessful;
use App\Events\RegisteredUser;
use App\Events\Searched;
use App\Listeners\AddCreditsToNewUser;
use App\Listeners\EmailCreditAdded;
use App\Listeners\EmailCreditExpired;
use App\Listeners\EmailCreditReminder;
use App\Listeners\EmailCreditSpent;
use App\Listeners\EmailListingApproved;
use App\Listeners\EmailListingCreated;
use App\Listeners\EmailListingUpdated;
use App\Listeners\EmailListingRejected;
use App\Listeners\EmailMessageReceived;
use App\Listeners\EmailUserCreated;
use App\Listeners\SaveSearch;
use App\Listeners\TrackCreditAdded;
use App\Listeners\TrackCreditExpired;
use App\Listeners\TrackCreditReminder;
use App\Listeners\TrackCreditSpent;
use App\Listeners\TrackListingApproved;
use App\Listeners\TrackListingCreated;
use App\Listeners\TrackListingUpdated;
use App\Listeners\TrackListingRejected;
use App\Listeners\TrackMessageReceived;
use App\Listeners\TrackPaymentError;
use App\Listeners\TrackUserCreated;
use Illuminate\Auth\Events\Registered;
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
        RegisteredUser::class => [
            AddCreditsToNewUser::class,
            EmailUserCreated::class,
            TrackUserCreated::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class
        ],
        CreditAdded::class => [
            EmailCreditAdded::class,
            TrackCreditAdded::class
        ],
        CreditSpent::class => [
            EmailCreditSpent::class,
            TrackCreditSpent::class
        ],
        CreditExpired::class => [
            TrackCreditExpired::class,
            EmailCreditExpired::class
        ],
        CreditReminder::class => [
            EmailCreditReminder::class,
            TrackCreditReminder::class
        ],
        ListingCreated::class => [
            EmailListingCreated::class,
            TrackListingCreated::class
        ],
        ListingUpdated::class => [
            EmailListingUpdated::class,
            TrackListingUpdated::class
        ],
        ListingApproved::class => [
            EmailListingApproved::class,
            TrackListingApproved::class
        ],
        ListingRejected::class => [
            EmailListingRejected::class,
            TrackListingRejected::class
        ],
        MessageReceived::class => [
            EmailMessageReceived::class,
            TrackMessageReceived::class,
        ],
        PaymentError::class => [
            TrackPaymentError::class
        ],
        PaymentSuccessful::class => [
            TrackPaymentError::class
        ],
        Searched::class => [
            SaveSearch::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
