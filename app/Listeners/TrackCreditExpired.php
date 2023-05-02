<?php

namespace App\Listeners;

use App\Events\CreditExpired;
use App\Events\CreditReminder;
use App\Mail\CreditReminderUser;
use App\Models\Tracker;
use Illuminate\Support\Facades\Mail;

class TrackCreditExpired
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
        $tracker = Tracker::create([
            'user_id' => $event->credit->user->id,
            'action' => 'credit expired',
            'data' => [
                'email_sent' => true,
                'amount' => $event->credit->amount,
                'total' => 0,
                'expiration_date' => $event->credit->expiration_date,
            ]
        ]);
    }
}
