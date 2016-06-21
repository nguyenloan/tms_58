<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Models\Course;
use Models\User;
use Models\Task;

class Subject extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_subjects');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subjects');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
