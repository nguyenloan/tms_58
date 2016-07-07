<?php

namespace App\Repositories\Course;

use App\Events\CourseActivity;
use App\Models\Activity;
use App\Models\Subject;
use App\Models\Task;
use App\Models\UserSubject;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use App\Models\Course;
use Exception;
use Auth;
use App\Models\User;
use App\Models\UserCourse;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function __construct(Course $course)
    {
        $this->model = $course;
    }

    public function find($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        $data['subjects'] = $data->subjects;
        $data['users'] = $data->users;

        if (!$data['subjects']) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        return $data;
    }

    public function addSuppervisor($input)
    {
        $data = UserCourse::create($input);

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        $data['subjects'] = $data->subjects;

        if (!$data['subjects']) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        $data['activities'] = Activity::where('course_id', $id)->get();
        $userCourse = UserCourse::where(['user_id' => Auth::user()->id, 'course_id' => $id])->get();

        if (!count($userCourse)) {
            $data['enroll'] = true;
        }

        return $data;
    }

    public function trainees($courseId)
    {
        $course = $this->model->find($courseId);

        if (!$course) {
            throw new Exception(trans('general/message.course_not_exist'));
        }

        $trainees = $course->users;

        if (!$trainees) {
            throw new Exception(trans('general/message.trainee_empty'));
        }

        $course['trainees'] = $trainees;

        return $course;
    }

    public function enroll($courseId)
    {
        $enroll = UserCourse::where(['user_id' => Auth::user()->id, 'course_id' => $courseId])->count();

        if ($enroll) {
            throw new Exception(trans('general/message.enrolled_this_course'));
        }

        $input = [
            'user_id' => Auth::user()->id,
            'course_id' => $courseId,
            'start_date' => date("Y-m-d H:i:s")
        ];
        $data = UserCourse::create($input);
        $data['type'] = config('common.activity.type.start_course');
        event(new CourseActivity($data));

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }

    public function userCourses($userId)
    {
        $limit = config('common.course.limit');
        $courses = UserCourse::where('user_id', $userId)
            ->join('courses', 'user_courses.course_id', '=', 'courses.id')->paginate($limit);
        foreach ($courses as $key => $course) {
            $courses[$key]['subjects'] = UserSubject::where('user_id', $userId)
                ->join('subjects', 'user_subjects.subject_id', '=', 'subjects.id')
                ->join('course_subjects', 'course_subjects.subject_id', '=', 'user_subjects.subject_id')
                ->where('course_id', $course['id'])->get();
        }

        return $courses;
    }

    public function traineeProgress($id)
    {
        $course = $this->model->find($id);
        $subjectIds = $course->subjects->lists('id');
        $tasks = Task::whereIn('subject_id', $subjectIds)->get();
        $taskCount = $tasks->count();
        $limit = config('common.base_repository.limit');
        $users = $course->users()->with('tasks')->paginate($limit);

        if (!count($users)) {
            throw new Exception(trans('general/message.trainee_is_empty'));
        }

        $completedTrainees = 0;
        foreach ($users as $key => $user) {
            $userTaskCount = 0;
            $users[$key]['completed'] = 0;

            if (count($user->tasks)) {
                foreach ($user->tasks as $task) {
                    $userTaskCount += $task->pivot->status;
                }
                $users[$key]['completed'] = ($userTaskCount / $taskCount) * 100;
            }

            if ($userTaskCount == $taskCount) {
                $completedTrainees++;
            }

        }

        $userCount = count($users);
        $data = [
            'users' => $users,
            'totalTrainee' => $userCount,
            'completed' => $completedTrainees,
            'training' => $userCount - $completedTrainees,
        ];

        return $data;
    }
}
