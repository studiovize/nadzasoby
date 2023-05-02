<?php

namespace App\Listeners;

use App\Events\ListingUpdated;
use App\Mail\ListingUpdatedAdmin;
use Illuminate\Support\Facades\Mail;

class EmailListingUpdated
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
        Mail::to(getAdminEmails())->send(new ListingUpdatedAdmin($event->listing));
//        Mail::to($event->listing->user->email)->send(new ListingCreatedUser($event->listing));
    }
}
