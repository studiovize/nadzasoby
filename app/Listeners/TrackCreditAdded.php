<?php

namespace App\Listeners;

use App\Events\CreditAdded;
use App\Events\CreditSpent;
use App\Events\ListingCreated;
use App\Mail\CreditAddedAdmin;
use App\Mail\CreditAddedUser;
use App\Mail\CreditSpentAdmin;
use App\Mail\ListingCreatedAdmin;
use App\Mail\ListingCreatedUser;
use App\Models\Tracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TrackCreditAdded
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
     * @param CreditAdded $event
     * @return void
     */
    public function handle(CreditAdded $event)
    {
        $plan = $event->credit->user->payments->last()->plan;

        $tracker = Tracker::create([
            'user_id' => $event->credit->user->id,
            'action' => 'added credit',
            'data' => [
                'amount' => $plan->credits,
                'extra' => $plan->extra,
                'total' => $event->credit->amount,
                'reason' => 'payment'
            ]
        ]);
    }
}
