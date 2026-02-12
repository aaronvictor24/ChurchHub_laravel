<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'church_id',
        'amount',
        'description',
        'purpose',
        'requested_by',
        'released_to',
        'expense_date',
        'created_by',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'church_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
