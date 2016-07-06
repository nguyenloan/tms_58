<?php

namespace App\Listeners;

use App\Events\SubjectActivity;
use App\Models\Subject;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Activity\ActivityRepositoryInterface;

class SubjectActivityListener
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
     * @param  SubjectActivity  $event
     * @return void
     */
    public function handle(SubjectActivity $event)
    {
        $this->activityRepository->store($event->userSubject);
    }
}
