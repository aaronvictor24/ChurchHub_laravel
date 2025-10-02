<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class NewMemberAdded extends Notification
{
    use Queueable;

    public $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member->load('church', 'secretary'); // eager load church
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // stored in notifications table
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'member_id'   => $this->member->member_id,
            'member_name' => $this->member->first_name . ' ' . $this->member->last_name,
            'church'      => $this->member->church?->name,
            'secretary'   => $this->member->secretary?->full_name, // now works
            'message'     => "New member <strong>{$this->member->first_name} {$this->member->last_name}</strong> 
          was added  
          from <strong>{$this->member->church?->name}</strong>.",
        ];
    }
}
