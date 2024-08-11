<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::send([], [], function ($message) use ($validated) {
            $message->to('support@eza.com')
                    ->subject($validated['subject'])
                    ->from($validated['email'], $validated['name'])
                    ->setBody($validated['message'], 'text/html');
        });

        return back()->with('success', 'Your message has been sent successfully.');
    }
}
