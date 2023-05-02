<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CookieController extends Controller
{
    public function settings()
    {
        return view('cookies.settings');
    }

    private function isGranted($haystack, $needle)
    {
        return (isset($haystack[$needle]) && $haystack[$needle] === 'on') ? 'granted' : 'denied';
    }

    public function store(Request $request)
    {
        $COOKIE_DAYS = 30;

        $data = $request->except('_token');

        $cookie_settings = [
            'required' => 'granted',
            'analytics_storage' => $this->isGranted($data, 'analytics_storage'),
            'ad_storage' => $this->isGranted($data, 'ad_storage'),
        ];

        setcookie('nadzasoby_cookies', json_encode($cookie_settings), time() + (86400 * $COOKIE_DAYS), "/");

        return back();
    }
}
