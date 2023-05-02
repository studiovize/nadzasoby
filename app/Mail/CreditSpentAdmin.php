<?php

namespace App\Mail;

use App\Models\Credit;
use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreditSpentAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $credit;
    public $spent;
    public $reason;
    public $listing;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Uživatel utratil kredity')
            ->markdown('emails.credit_spent_admin')
            ->with([
                'spent' => $this->spent,
                'total' => $this->credit->amount,
                'user' => Auth::user(),
                'reason' => $this->reason,
                'listing' => $this->listing
            ]);
    }
}
