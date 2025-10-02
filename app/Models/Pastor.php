<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    use HasFactory;

    protected $table = 'tbl_pastors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'email',
        'age',
        'contact_number',
        'address',
        'date_of_birth',
        'gender',
        'is_deleted',
    ];

    public function churches()
    {
        return $this->hasMany(Church::class, 'pastor_id', 'id');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucwords(strtolower($value));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower($value));
    }

    public function setSuffixNameAttribute($value)
    {
        $this->attributes['suffix_name'] = ucwords(strtolower($value));
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(strtolower($value));
    }


    public function getFullNameAttribute()
    {
        return trim(ucwords(strtolower(
            "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix_name}"
        )));
    }
}
