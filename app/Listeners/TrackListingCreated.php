<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Models\Tracker;

class TrackListingCreated
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
     * @param ListingCreated $event
     * @return void
     */
    public function handle(ListingCreated $event)
    {
        Tracker::create([
            'user_id' => $event->listing->user->id,
            'action' => 'created listing',
            'data' => [
                'listing_id' => $event->listing->id,
                'is_highlighted' => $event->listing->is_highlighted,
                'type' => $event->listing->type,
                'json' => json_encode($event->listing)
            ]
        ]);
    }
}
