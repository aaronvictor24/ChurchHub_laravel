<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    use HasFactory;

    protected $table = 'tbl_secretaries';

    protected $primaryKey = 'secretary_id';

    protected $fillable = [
        'church_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'age',
        'birth_date',
        'gender',
        'address',
        'contact_number',
        'email',
        'password',
        'is_deleted',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'secretary_id', 'secretary_id');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix_name}");
    }

    public function getDisplayNameAttribute()
    {
        $middleInitial = '';
        if (!empty($this->middle_name)) {
            $firstMiddlePart = trim(explode(' ', $this->middle_name)[0]);
            if ($firstMiddlePart !== '') {
                $middleInitial = strtoupper(substr($firstMiddlePart, 0, 1)) . '.';
            }
        }

        $parts = array_filter([
            $this->first_name,
            $middleInitial,
            $this->last_name,
            $this->suffix_name
        ]);

        return implode(' ', $parts);
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
        $this->attributes['suffix_name'] = strtoupper($value); // Ex: JR, SR, III
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(strtolower($value));
    }
}
