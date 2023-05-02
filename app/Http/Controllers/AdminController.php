<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function stats()
    {
        $today = Carbon::now()->setTime(0, 0, 0);
        $month = Carbon::now()->subDays(30);

        $users_today = User::where('created_at', '>=', $today)->count();
        $users_month = User::where('created_at', '>=', $month)->count();
        $users_total = User::count();

        $listings_today = Listing::where('created_at', '>=', $today)->count();
        $listings_month = Listing::where('created_at', '>=', $month)->count();
        $listings_total = Listing::count();

        $data = [
            [
                'title' => 'Uživatelé',
                'cols' => [
                    [
                        'label' => 'Dnes',
                        'value' => $users_today
                    ],
                    [
                        'label' => '30 dní',
                        'value' => $users_month
                    ],
                    [
                        'label' => 'Celkem',
                        'value' => $users_total
                    ],
                ],
            ],
            [
                'title' => 'Nabídky',
                'cols' => [
                    [
                        'label' => 'Dnes',
                        'value' => $listings_today
                    ],
                    [
                        'label' => '30 dní',
                        'value' => $listings_month
                    ],
                    [
                        'label' => 'Celkem',
                        'value' => $listings_total
                    ],
                ],
            ]
        ];

        $popular_listings = Listing::orderBy('views', 'desc')->limit(5)->get();

        return view('admin.stats')->with(compact('data', 'popular_listings'));
    }

    public function users()
    {
//        $users = User::where('id', '!=', Auth::id())->get();
        $users = User::all();
        return view('admin.users')->with(compact('users'));
    }

    public function usersShow(User $user)
    {
        $data = getUserDataForAdmin($user);
        return view('admin.users-show')->with($data);

        return view('admin.users-show')->with(compact('user'));
    }
}
