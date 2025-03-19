<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a list of all of the user's notifications.
     */
    public function index(Request $request)
    {
        // Fetch all notifications for the authenticated user
        // including both read and unread.
        $notifications = $request->user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function dismiss($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead(); // or delete()
        return back();
    }


    /**
     * Display a single notification details and mark it as read.
     */
    public function show(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        // Mark as read if it’s still unread
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->route('notifications.index');
    }
}
