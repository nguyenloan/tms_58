<?php

namespace App\Listeners;

use App\Events\CourseActivity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Activity\ActivityRepositoryInterface;

class CourseActivityListener
{

    private $activityRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Handle the event.
     *
     * @param  CourseActivity  $event
     * @return void
     */
    public function handle(CourseActivity $event)
    {
        $this->activityRepository->store($event->userCourse);
    }
}
