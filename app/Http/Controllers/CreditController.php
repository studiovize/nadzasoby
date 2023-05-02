<?php

namespace App\Http\Controllers;

use App\Events\CreditExpired;
use App\Events\CreditReminder;
use App\Models\Credit;
use App\Models\Plan;
use App\Models\Tracker;
use Illuminate\Support\Carbon;

class CreditController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('credits.index')->with([
            'plans' => $plans
        ]);
    }

    public function expiredCredit()
    {
        $credit_to_check = Credit::where('status', '=', 'active')->get();

        foreach ($credit_to_check as $credit) {
            if (isset($credit->expiration_date)) {
                $expiration = $credit->expiration_date;
                $now = Carbon::now();

                // if should expire
                if ($now->isAfter($expiration)) {
                    event(new CreditExpired($credit));
                    $credit->status = 'expired';
                    $credit->amount = 0;
                    $credit->save();
                } // if expires in 7 days?
                else if ($now->addDays(7)->diffInDays($expiration) === 0) {
                    event(new CreditReminder($credit));
                } // if expires in 1 month?
                else if ($now->addDays(30)->diffInDays($expiration) === 0) {
                    event(new CreditReminder($credit));
                }
            }
        }
    }
}
