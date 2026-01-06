<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MassOffering extends Model
{
    protected $fillable = [
        'mass_id',
        'amount',
        'remarks',
        'encoded_by',
    ];

    public function mass()
    {
        return $this->belongsTo(Mass::class, 'mass_id', 'mass_id');
    }

    public function encoder()
    {
        return $this->belongsTo(User::class, 'encoded_by', 'id');
    }
}
