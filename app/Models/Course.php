<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Models\Subject;
use Models\User;

class Course extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subjects');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses');
    }
}
