<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserHasUnlockedListing
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
        $listing = $request->route('listing');

        if (!$request->user()->hasUnlocked($listing)) {
            return redirect(route('listings.confirm-unlock', ['listing' => $listing]));
        }

        return $next($request);
    }
}
