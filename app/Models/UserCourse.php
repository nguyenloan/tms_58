<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'start_date', 'end_date', 'status',
    ];

    public function getStatusAttribute($value)
    {
        $status = trans('general/label.training');

        if ($value) {
            $status = trans('general/label.completed');
        }

        return $status;
    }
}
