<?php

namespace App\Listeners;

use App\Events\CreditAdded;
use App\Events\ListingCreated;
use App\Mail\CreditAddedAdmin;
use App\Mail\CreditAddedUser;
use App\Mail\ListingCreatedAdmin;
use App\Mail\ListingCreatedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailCreditAdded
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
     * @param CreditAdded $event
     * @return void
     */
    public function handle(CreditAdded $event)
    {
        // todo: tohle mozna nebude fungovat
//        $amount = $event->credit->user->payments->last()->plan->credits;
        Mail::to(getAdminEmails())->send(new CreditAddedAdmin($event->credit, $event->amount));
        Mail::to($event->credit->user->email)->send(new CreditAddedUser($event->credit, $event->amount));
    }
}
