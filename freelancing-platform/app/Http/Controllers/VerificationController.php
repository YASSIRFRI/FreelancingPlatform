<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            //'verification_id'=>"required|string",
            'verification_paper' => 'required|mimes:pdf,jpg,jpeg,png'
        ]);
        Log::info($request->all());

        $path = $request->file('verification_paper')->store('verification_papers', 'public');

        VerificationRequest::create([
            'user_id' => Auth::id(),
            'verification_paper' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('profile.index')->with('success', 'Verification request submitted successfully.');
    }
}
