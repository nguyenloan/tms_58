<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Activity\ActivityRepositoryInterface;
use App\Repositories\UserCourse\UserCourseRepository;
use App\Repositories\UserCourse\UserCourseRepositoryInterface;
use App\Repositories\CourseSubject\CourseSubjectRepository;
use App\Repositories\CourseSubject\CourseSubjectRepositoryInterface;
use App\Repositories\Report\ReportRepository;
use App\Repositories\Report\ReportRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('layout', config('common.layout.general'));
        view()->share('managements', config('common.layout.managements'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(UserRepositoryInterface::class, UserRepository::class);
        App::bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        App::bind(CourseRepositoryInterface::class, CourseRepository::class);
        App::bind(TaskRepositoryInterface::class, TaskRepository::class);
        App::bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        App::bind(UserCourseRepositoryInterface::class, UserCourseRepository::class);
        App::bind(CourseSubjectRepositoryInterface::class, CourseSubjectRepository::class);
        App::bind(ReportRepositoryInterface::class, ReportRepository::class);
    }
}
