<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MassAttendance extends Model
{
    protected $fillable = [
        'mass_id',
        'member_id',
        'attended'
    ];

    public function mass()
    {
        return $this->belongsTo(Mass::class, 'mass_id', 'mass_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
