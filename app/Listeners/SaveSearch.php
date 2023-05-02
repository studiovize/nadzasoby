<?php

namespace App\Listeners;

use App\Events\Searched;
use App\Models\Search;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveSearch
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Searched $event
     * @return void
     */
    public function handle(Searched $event)
    {
        $data = $event->search_data;

        if (isset($data['category_id']) && isset($data['area_id'])) {
            Search::create($data);
        }
    }
}
