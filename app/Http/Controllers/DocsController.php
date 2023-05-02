<?php

namespace App\Http\Controllers;

class DocsController extends Controller
{
    public function terms()
    {
        return view('docs.terms');
    }

    public function personalData()
    {
        return view('docs.personal-data');
    }
}
