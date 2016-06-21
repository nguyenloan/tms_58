<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Models\User;
use Models\Subject;

class Task extends Model
{
    protected $fillable = [
        'subject_id', 'name', 'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
