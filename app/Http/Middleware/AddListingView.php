<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddListingView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $listing = $request->listing;
        if(!$listing) return $next($request);

        $record = DB::table('listing_views')->where([
            ['listing_id', '=', $listing->id],
            ['ip', '=', $request->ip()]
        ]);

        if(!$record->exists()){
            $listing->increment('views');

            DB::table('listing_views')->insert([
                'listing_id' => $listing->id,
                'ip' => $request->ip(),
                'user_id' => Auth::check() ? Auth::user()->id : null
            ]);
        }

        return $next($request);
    }
}
