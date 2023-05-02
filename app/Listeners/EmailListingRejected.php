<?php

namespace App\Listeners;

use App\Events\ListingRejected;
use App\Mail\ListingRejectedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailListingRejected
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
        Mail::to($event->listing->user->email)->send(new ListingRejectedUser($event->listing));
    }
}
