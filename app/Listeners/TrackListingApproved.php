<?php

namespace App\Listeners;

use App\Models\Tracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TrackListingApproved
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Tracker::create([
            'user_id' => $event->listing->user->id,
            'action' => 'approved listing',
            'data' => [
                'listing_id' => $event->listing->id
            ]
        ]);
    }
}
