<?php

namespace App\Events;

use App\Models\Credit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CreditAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $credit;
    public $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Credit $credit, $amount)
    {
        $this->credit = $credit;
        $this->amount = $amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
