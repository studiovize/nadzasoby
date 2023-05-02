<?php

namespace App\Listeners;

use App\Events\CreditSpent;
use App\Models\Tracker;

class TrackCreditSpent
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
     * @param CreditSpent $event
     * @return void
     */
    public function handle(CreditSpent $event)
    {
        $tracker = Tracker::create([
            'user_id' => $event->credit->user->id,
            'action' => 'spent credit',
            'data' => [
                'amount' => $event->spent,
                'remaining' => $event->credit->amount,
                'reason' => $event->reason,
                'listing_id' => $event->listing->id
            ]
        ]);
    }
}
