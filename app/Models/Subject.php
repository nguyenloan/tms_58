<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\User;
use App\Models\Task;
use App\Models\CourseSubject;

class Subject extends Model
{

    protected $fillable = [
        'name', 'description',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_subjects', 'course_id', 'subject_id');
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
