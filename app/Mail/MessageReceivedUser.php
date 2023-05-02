<?php

namespace App\Mail;

use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class MessageReceivedUser extends Mailable
{
    use Queueable, SerializesModels;

    public $thread;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Máte nepřečtenou zprávu')
            ->markdown('emails.new_message');
    }
}
