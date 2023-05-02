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
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailCreditSpent
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
        Mail::to(getAdminEmails())->send(new CreditSpentAdmin($event->credit, $event->spent, $event->reason, $event->listing));
    }
}
