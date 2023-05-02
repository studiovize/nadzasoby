<?php

namespace App\Listeners;

use App\Events\ListingUpdated;
use App\Models\Tracker;

class TrackListingUpdated
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
     * @param ListingUpdated $event
     * @return void
     */
    public function handle(ListingUpdated $event)
    {
        Tracker::create([
            'user_id' => $event->listing->user->id,
            'action' => 'updated listing',
            'data' => [
                'listing_id' => $event->listing->id,
                'is_highlighted' => $event->listing->is_highlighted,
                'type' => $event->listing->type,
                'json' => json_encode($event->listing)
            ]
        ]);
    }
}
