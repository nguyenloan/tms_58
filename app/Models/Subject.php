<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\User;
use App\Models\Task;

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

    public function getStatusAttribute($value)
    {
        $status = trans('general/label.training');

        if ($value) {
            $status = trans('general/label.completed');
        }

        return $status;
    }
}
