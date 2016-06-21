<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Models\User;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id', 'date', 'achievement', 'next_day_plan', 'problem',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
