<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserHasCredit
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->credit->amount <= 0) {
            return redirect(route('credits.index'));
        }

        return $next($request);
    }
}
