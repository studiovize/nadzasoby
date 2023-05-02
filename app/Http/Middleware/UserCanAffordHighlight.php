<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserCanAffordHighlight
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->credit->amount >= (int) env('PRICE_HIGHLIGHT')) {
            return $next($request);
        }

        return redirect()->to(route('credits.index'));
    }
}
