<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Events\ListingRejected;
use App\Mail\ListingCreatedAdmin;
use App\Mail\ListingCreatedUser;
use App\Mail\ListingRejectedUser;
use App\Models\Tracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TrackListingRejected
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
     * @param ListingRejected $event
     * @return void
     */
    public function handle(ListingRejected $event)
    {
        $tracker = Tracker::create([
            'user_id' => $event->listing->user->id,
            'action' => 'rejected listing',
            'data' => [
                'listing_id' => $event->listing->id,
                'done_by' => Auth::check() ? Auth::id() : 'unknown'
            ]
        ]);
    }
}
