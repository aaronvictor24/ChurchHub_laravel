<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'church_id',
        'secretary_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'email',
        'contact_number',
        'birth_date',
        'age',
        'gender',
        'address',
    ];

    public function getAgeAttribute()
    {
        return $this->birth_date
            ? Carbon::parse($this->birth_date)->age
            : null;
    }

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }

    public function secretary()
    {
        return $this->belongsTo(\App\Models\Secretary::class, 'secretary_id', 'secretary_id');
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'member_id');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucfirst(strtolower($value));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    public function setSuffixNameAttribute($value)
    {
        $this->attributes['suffix_name'] = strtoupper($value); // e.g. JR, SR, III
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(strtolower($value));
    }
}
