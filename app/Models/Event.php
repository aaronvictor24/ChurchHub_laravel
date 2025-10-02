<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'church_id',
        'secretary_id',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class, 'secretary_id', 'secretary_id');
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'event_id', 'event_id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords(strtolower($value));
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = ucwords(strtolower($value));
    }

    public function getFormattedDateAttribute()
    {
        return $this->event_date
            ? Carbon::parse($this->event_date)->format('F d, Y')
            : null;
    }

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time
            ? Carbon::parse($this->start_time)->format('h:i A')
            : null;
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time
            ? Carbon::parse($this->end_time)->format('h:i A')
            : null;
    }
}
