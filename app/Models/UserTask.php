<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $fillable = [
        'user_id', 'task_id', 'status',
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
