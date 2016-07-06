<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SubjectActivity extends Event
{
    use SerializesModels;

    public $userSubject;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userSubject)
    {
        $this->userSubject = $userSubject;
    }
}
