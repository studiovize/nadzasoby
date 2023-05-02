<?php

namespace App\Listeners;

use App\Events\CreditReminder;
use App\Mail\CreditReminderUser;
use Illuminate\Support\Facades\Mail;

class EmailCreditReminder
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
     * @param CreditReminder $event
     * @return void
     */
    public function handle(CreditReminder $event)
    {
        Mail::to($event->credit->user->email)->send(new CreditReminderUser($event->credit));
    }
}
