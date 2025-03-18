<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $unreadNotifications = $user->activities()->whereNull('tbl_activity_user.read_at')->limit(15)->get();

        return response()->json([
            'count' => $unreadNotifications->count(),
            'notifications' => $unreadNotifications
        ]);
    }

    public function markAsRead()
    {
        $user = Auth::user();
        $user->activities()->updateExistingPivot($user->activities->pluck('activity_id'), ['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
