<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Events\ListingRejected;
use App\Events\MessageReceived;
use App\Mail\MessageReceivedUser;
use App\Mail\ListingRejectedUser;
use App\Models\Tracker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TrackMessageReceived
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
        $tracker = Tracker::create([
            'user_id' => $event->thread->users[0]->id,
            'action' => 'sent message',
            'data' => [
                'thread_id' => $event->thread->id
            ]
        ]);
    }
}
