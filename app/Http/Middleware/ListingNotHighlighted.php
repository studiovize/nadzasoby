<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ListingNotHighlighted
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
        return !$request->listing->is_highlighted ? $next($request) : redirect()->to(route('listings.show', $request->listing));
    }
}
