<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Events\ListingRejected;
use App\Events\MessageReceived;
use App\Events\PaymentError;
use App\Events\PaymentSuccessful;
use App\Mail\MessageReceivedUser;
use App\Mail\ListingRejectedUser;
use App\Models\Tracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TrackPaymentSuccessful
{
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
     * @param PaymentSuccessful $event
     * @return void
     */
    public function handle(PaymentSuccessful $event)
    {
        $tracker = Tracker::create([
            'user_id' => $event->payment->user->id,
            'action' => 'payment successful',
            'data' => [
                'payment_id' => $event->payment->id
            ]
        ]);
    }
}
