<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all notifications for the authenticated user
        $notifications = Notification::where('user_id', Auth::id())->latest()->get();

        // Return the notifications index view
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        // Find the notification by its ID
        $notification = Notification::findOrFail($id);

        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Mark the notification as read
        $notification->update(['is_read' => true]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Delete a notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the notification by its ID
        $notification = Notification::findOrFail($id);

        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the notification
        $notification->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Notification deleted.');
    }
}
