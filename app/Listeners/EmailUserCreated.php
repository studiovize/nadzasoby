<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Mail\UserRegistered;
use App\Models\Credit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailUserCreated
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
        Mail::to($event->user->email)->send(new UserRegistered($event->user));
    }
}
