<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMessage;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $data = $request->only([
            'name',
            'email',
            'message'
        ]);

        $message = new ContactMessage($data);

        try {
            $message->save();

            Mail::to(getAdminEmails())->send(new ContactFormMessage($data));

            $response = [
                'status' => 200,
                'message' => 'success'
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
