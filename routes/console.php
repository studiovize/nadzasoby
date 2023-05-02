<?php

use App\Mail\CreditAddedAdmin;
use App\Models\Credit;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
//    $credit = Credit::first();
//    Mail::to('info@mihailo.cz')->send(new CreditAddedAdmin($credit));
})->purpose('Display an inspiring quote');
