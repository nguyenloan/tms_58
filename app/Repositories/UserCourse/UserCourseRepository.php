<?php

namespace App\Repositories\UserCourse;

use App\Models\Task;
use App\Models\UserSubject;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use Exception;
use App\Models\UserCourse;
use App\Models\CourseSubject;
use Auth;
use App\Models\Course;
use DB;

class UserCourseRepository extends BaseRepository implements UserCourseRepositoryInterface
{
    public function __construct(UserCourse $userCourse)
    {
        $this->model = $userCourse;
    }

    public function store($inputs)
    {
        $data = $this->model->insert($inputs);

        $subjectIds = CourseSubject::where('course_id', $inputs[0]['course_id'])->lists('subject_id');
        // insert user subjects
        if(count($subjectIds)){
            $subjects = [];
            foreach ($subjectIds as $subjectId) {
                foreach ($inputs as $input) {
                    $subjects[] = [
                        'user_id' => $input['user_id'],
                        'subject_id' => $subjectId,
                        'status' => config('common.subject.status.start'),
                        'start_date' => date("Y-m-d H:i:s"),
                    ];
                }
            }
            UserSubject::insert($subjects);
            // insert user tasks
            $tasks = [];
            $taskIds = Task::whereIn('subject_id', $subjectIds)->lists('id');
            foreach ($taskIds as $taskId) {
                foreach ($inputs  as $input) {
                    $tasks[] = [
                        'user_id' => $input['user_id'],
                        'task_id' => $taskId,
                        'status' => config('common.user_task.status.training')
                    ];
                }
            }
            UserTask::insert($tasks);
        }

        return $data;
    }
}
