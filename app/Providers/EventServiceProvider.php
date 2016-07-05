<?php

namespace App\Providers;

use App\Events\CourseActivity;
use App\Events\SubjectActivity;
use App\Models\UserCourse;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\UserSubject;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CourseActivity' => [
            'App\Listeners\CourseActivityListener',
        ],
        'App\Events\SubjectActivity' => [
            'App\Listeners\SubjectActivityListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
