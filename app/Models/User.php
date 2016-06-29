<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Models\Course;
use Models\Subject;
use Models\Task;
use Models\DailyReport;
use Models\Activity;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const ROLE_SUPERVISOR = 0;
    const ROLE_TRAINEE = 1;
    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'user_subjects');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks');
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function isAdmin()
    {
        return $this->role == User::ROLE_SUPERVISOR;
    }
}
