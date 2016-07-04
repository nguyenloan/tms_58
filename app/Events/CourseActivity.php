<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CourseActivity extends Event
{
    use SerializesModels;

    public $userCourse;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userCourse)
    {
        $this->userCourse = $userCourse;
    }
}
