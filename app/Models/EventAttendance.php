<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    protected $primaryKey = 'attendance_id';
    protected $fillable = [
        'event_id',
        'member_id',
        'attended'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
