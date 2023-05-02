<?php

namespace App\Listeners;

use App\Events\ListingApproved;
use App\Mail\ListingApprovedUser;
use Illuminate\Support\Facades\Mail;

class EmailListingApproved
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
    public function handle(ListingApproved $event)
    {
        Mail::to($event->listing->user->email)->send(new ListingApprovedUser($event->listing));
    }
}
