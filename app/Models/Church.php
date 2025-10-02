<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $table = 'tbl_churches'; // explicitly set the table name
    protected $primaryKey = 'church_id'; // since you used church_id, not id

    protected $fillable = [
        'name',
        'address',
        'pastor_id',
    ];

    public function pastor()
    {
        return $this->belongsTo(Pastor::class, 'pastor_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'church_id', 'church_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(strtolower($value));
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->name} - {$this->address}";
    }
}
