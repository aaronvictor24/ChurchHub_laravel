<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mass extends Model
{
    use HasFactory;

    protected $table = 'tbl_masses';
    protected $primaryKey = 'mass_id';

    protected $fillable = [
        'church_id',
        'mass_title',
        'mass_type',
        'mass_date',
        'start_time',
        'end_time',
        'day_of_week',
        'is_recurring',
        'description',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }

    public function attendances()
    {
        return $this->hasMany(MassAttendance::class, 'mass_id', 'mass_id');
    }

    public function offerings()
    {
        return $this->hasMany(MassOffering::class, 'mass_id', 'mass_id');
    }

    public function getRouteKeyName()
    {
        return 'mass_id';
    }
}
