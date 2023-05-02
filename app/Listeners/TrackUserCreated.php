<?php

namespace App\Listeners;

use App\Events\CreditAdded;
use App\Events\ListingCreated;
use App\Events\RegisteredUser;
use App\Mail\CreditAddedAdmin;
use App\Mail\CreditAddedUser;
use App\Mail\ListingCreatedAdmin;
use App\Mail\ListingCreatedUser;
use App\Models\Tracker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TrackUserCreated
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
     * @param RegisteredUser $event
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        $tracker = Tracker::create([
            'user_id' => $event->user->id,
            'action' => 'registration',
            'data' => $event->user->toArray()
        ]);

        $tracker_credits = Tracker::create([
            'user_id' => $event->user->id,
            'action' => 'added credit',
            'data' => [
                'amount' => 2,
                'remaining' => $event->user->credit->amount,
                'reason' => 'registration',
                'listing_id' => null
            ]
        ]);
    }
}
