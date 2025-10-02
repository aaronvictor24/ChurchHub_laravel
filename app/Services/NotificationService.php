<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function create($type, $message, $userId = null, $churchId = null)
    {
        return Notification::create([
            'type' => $type,
            'message' => $message,
            'user_id' => $userId,
            'church_id' => $churchId,
        ]);
    }
}
