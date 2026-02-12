<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    use HasFactory;

    protected $table = 'tbl_tithes';
    protected $primaryKey = 'tithe_id';

    protected $fillable = [
        'church_id',
        'member_id',
        'is_pledge',
        'pledger_name',
        'mass_id',
        'amount',
        'date',
        'remarks',
        'encoder_id',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
    public function mass()
    {
        return $this->belongsTo(Mass::class, 'mass_id', 'mass_id');
    }
    public function encoder()
    {
        return $this->belongsTo(User::class, 'encoder_id', 'id');
    }
}
