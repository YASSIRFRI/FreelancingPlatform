<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        $averageRating = Review::whereHas('order', function ($query) use ($user) {
            $query->where('seller_id', $user->id); 
        })->avg('stars');

        return view('profile.index', compact('user','averageRating'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update user's data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->description = $request->description;
        $user->phone_number = $request->phone_number;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Handle user verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the verification paper
        $request->validate([
            'verification_id' => 'required|string|max:255',
            'verification_paper' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Store the verification paper
        if ($request->hasFile('verification_paper')) {
            // Delete old verification paper if exists
            if ($user->verification_paper) {
                Storage::delete($user->verification_paper);
            }

            // Store the new verification paper
            $path = $request->file('verification_paper')->store('verification_papers', 'public');
            $user->verification_paper = $path;
            $user->save();
        }

        return redirect()->route('profile.index')->with('success', 'Verification paper submitted. Please wait for verification.');
    }
}
