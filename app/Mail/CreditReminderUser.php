<?php

namespace App\Mail;

use App\Models\Credit;
use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreditReminderUser extends Mailable
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
        $now = Carbon::now();
        $expiration = $this->credit->expiration_date;
        $days = $now->diffInDays($expiration);

        return $this
            ->subject('Vaše kredity brzo vyprší')
            ->markdown('emails.credit_reminder')
            ->with([
                'total' => $this->credit->amount,
                'days' => $days,
            ]);
    }
}
