<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    protected $fillable = [
        'user_id', 'subject_id', 'status', 'start_date', 'end_date',
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
