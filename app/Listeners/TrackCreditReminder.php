<?php

namespace App\Listeners;

use App\Events\CreditReminder;
use App\Mail\CreditReminderUser;
use App\Models\Tracker;
use Illuminate\Support\Facades\Mail;

class TrackCreditReminder
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
        $tracker = Tracker::create([
            'user_id' => $event->credit->user->id,
            'action' => 'credit reminder',
            'data' => [
                'email_sent' => true,
                'amount' => $event->credit->amount,
                'expiration_date' => $event->credit->expiration_date,
            ]
        ]);
    }
}
