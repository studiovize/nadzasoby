<?php

namespace App\Mail;

use App\Models\Credit;
use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreditExpiredUser extends Mailable
{
    use Queueable, SerializesModels;

    public $credit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vaše kredity vypršely')
            ->markdown('emails.credit_expired')
            ->with([
                'total' => $this->credit->amount
            ]);
    }
}
