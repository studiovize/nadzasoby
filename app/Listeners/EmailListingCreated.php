<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Mail\ListingCreatedAdmin;
use App\Mail\ListingCreatedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailListingCreated
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
     * @param  ListingCreated  $event
     * @return void
     */
    public function handle(ListingCreated $event)
    {
        Mail::to(getAdminEmails())->send(new ListingCreatedAdmin($event->listing));
        Mail::to($event->listing->user->email)->send(new ListingCreatedUser($event->listing));
    }
}
