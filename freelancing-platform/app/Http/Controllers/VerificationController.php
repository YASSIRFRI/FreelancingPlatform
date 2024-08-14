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
            'verification_paper' => 'required|mimes:jpg,jpeg,png|max:6000',
            'verification_image' => 'required|mimes:jpg,jpeg,png|max:6000'
        ]);
        
        Log::info($request->all());

        $userId = Auth::id();
        
        $directory = "verification_papers/{$userId}";

        $paperPath = $request->file('verification_paper')->storeAs($directory, 'id_paper.jpg', 'public');
        
        // Store the verification image as id_image
        $imagePath = $request->file('verification_image')->storeAs($directory, 'id_image.jpg', 'public');
        VerificationRequest::create([
            'user_id' => $userId,
            'verification_paper' => $paperPath,
            'verification_image' => $imagePath, 
            'status' => 'pending',
        ]);

        return redirect()->route('profile.index')->with('success', 'Verification request submitted successfully.');
    }
}
