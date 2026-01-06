<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function history()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('secretary.notifications.history', compact('notifications'));
    }
}
