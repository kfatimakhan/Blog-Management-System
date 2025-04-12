<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id() && !$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
    // For reply notifications
    // if ($request->parent_id) {
    // $parentComment = Comment::find($request->parent_id);
    // if ($parentComment->user_id !== auth()->id()) {
    //     $parentComment->user->notifications()->create([
    //         'type' => 'reply',
    //         'message' => auth()->user()->username . ' replied to your comment'
    //     ]);

    //     event(new NewNotification($parentComment->user));
    // }
}

