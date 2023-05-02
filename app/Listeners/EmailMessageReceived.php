<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Events\ListingRejected;
use App\Events\MessageReceived;
use App\Mail\MessageReceivedUser;
use App\Mail\ListingRejectedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailMessageReceived
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
     * @param MessageReceived $event
     * @return void
     */
    public function handle(MessageReceived $event)
    {
        Mail::to($event->thread->users[0]->email)
            ->send(new MessageReceivedUser($event->thread));
    }
}
