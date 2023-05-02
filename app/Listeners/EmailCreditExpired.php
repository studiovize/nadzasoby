<?php

namespace App\Listeners;

use App\Events\CreditExpired;
use App\Mail\CreditExpiredUser;
use Illuminate\Support\Facades\Mail;

class EmailCreditExpired
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
     * @param CreditExpired $event
     * @return void
     */
    public function handle(CreditExpired $event)
    {
        Mail::to($event->credit->user->email)->send(new CreditExpiredUser($event->credit));
    }
}
