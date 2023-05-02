<?php

namespace App\Mail;

use App\Models\Credit;
use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreditAddedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $credit;
    public $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Credit $credit, $amount)
    {
        $this->credit = $credit;
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
            ->subject('Uživatel koupil kredity')
            ->markdown('emails.credit_added_admin')
            ->with([
                'user'  => $this->credit->user,
                'amount' => $this->amount
            ]);
    }
}
