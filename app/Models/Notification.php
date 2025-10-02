<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'church_id',
        'user_id',
        'type',
        'message',
        'is_read'
    ];
}
