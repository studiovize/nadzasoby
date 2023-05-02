<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserOwnsListing
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
        if ($request->listing->user_id === $request->user()->id) {
            return $next($request);
        }
        return redirect()->to(route('listings.my'));
    }
}
