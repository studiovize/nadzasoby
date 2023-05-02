<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCreditsAdded extends Mailable
{
    use Queueable, SerializesModels;

    private $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Kredity byly přičteny')
            ->markdown('emails.credit_for_registration')
            ->with([
                'amount' => $this->amount
            ]);
    }
}
