<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Models\User;

class Activity extends Model
{
    protected $fillable = [
        'user_id', 'description', 'type', 'subject_id', 'course_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
