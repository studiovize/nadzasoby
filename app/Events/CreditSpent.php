<?php

namespace App\Events;

use App\Models\Credit;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditSpent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $credit;
    public $spent;
    public $reason;
    public $listing;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Credit $credit, $spent, $reason, $listing)
    {
        $this->credit = $credit;
        $this->spent = $spent;
        $this->reason = $reason;
        $this->listing = $listing;
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
