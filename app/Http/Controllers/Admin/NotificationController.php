<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function viewMember(DatabaseNotification $notification)
    {
        // Mark as read
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        // Redirect to the member profile
        return redirect()->route('admin.members.show', $notification->data['member_id']);
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification deleted successfully!');
    }
}
