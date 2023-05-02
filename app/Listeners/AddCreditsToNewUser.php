<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Mail\RegistrationCreditsAdded;
use App\Models\Credit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AddCreditsToNewUser
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
     * @param RegisteredUser $event
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        // old - add zero credits
//        Credit::create([
//            'user_id' => $event->user->id,
//            'amount' => 0
//        ]);

        // new - add 2 credits with 14-day expiration
        $amount = 2;
        $expiration_days = 14;

        Credit::create([
            'user_id' => $event->user->id,
            'amount' => $amount,
            'expiration_date' => Carbon::now()->addDays($expiration_days)
        ]);

        Mail::to($event->user->email)->send(new RegistrationCreditsAdded($amount));
    }
}
