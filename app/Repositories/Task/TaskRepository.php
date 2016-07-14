<?php

namespace App\Repositories\Task;

use App\Events\CourseActivity;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Task;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserSubject;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use Exception;
use Auth;
use App\Events\SubjectActivity;
use Request;
use App\Models\Subject;
use DB;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function updateTaskStatus($ids)
    {
        $input = ['status' => config('common.user_task.status.finish')];

        if (is_array($ids)) {
            $data = UserTask::whereIn('id', $ids)->update($input);
            $userTask = UserTask::find($ids[0]);
        } else {
            $data = UserTask::where(['task_id' => $ids, 'user_id' => Auth::user()->id])->update($input);
            $userTask = UserTask::where(['task_id' => $ids, 'user_id' => Auth::user()->id])->first();
        }

        if (!$data) {
            throw new Exception(trans('general/message.update_error'));
        }

        // finish subject if all tasks in subject were completed
        $task = $this->finishSubject($userTask);

        // finish course if all subjects in course were completed
        if (isset($task['completed_subject'])) {
            $courseSubject = $this->finishCourse($task);
        }

        return $task;
    }

    public function find($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception("general/message.item_not_exist");
        }

        return $data;
    }

    public function store($inputs)
    {
        $data = $this->model->insert($inputs);

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }

    public function finishSubject($userTask)
    {
        $task = $this->model->where('id', $userTask['task_id'])->first();
        $taskIds = $this->model->where('subject_id', $task['subject_id'])->lists('id');
        $filter = [
            'user_id' => Auth::user()->id,
            'status' => config('common.user_task.status.finish'),
        ];
        $completedTasks = UserTask::whereIn('task_id', $taskIds)->where($filter)->get();

        if (count($taskIds) == count($completedTasks)) {
            $updatedData = [
                'end_date' => date("Y-m-d H:i:s"),
                'status' => config('common.subject.status.finish')
            ];
            UserSubject::where(['subject_id' => $task['subject_id'], 'user_id' => Auth::user()->id])->update($updatedData);
            $task['completed_subject'] = true;

            $courseSubject = CourseSubject::where('subject_id', $task['subject_id'])->first();
            $eventData = [
                'type' => config('common.activity.type.finish_subject'),
                'subject_id' => $task['subject_id'],
                'course_id' => $courseSubject['course_id'],
                'subject' => Subject::find($task['subject_id'])->name,
            ];

            event(new SubjectActivity($eventData));
        }

        return $task;
    }

    public function finishCourse($task)
    {
        $courseSubject = CourseSubject::where('subject_id', $task['subject_id'])->first();
        $subjectIds = CourseSubject::where('course_id', $courseSubject['course_id'])->lists('subject_id');
        $filter = [
            'user_id' => Auth::user()->id,
            'status' => config('common.subject.status.finish'),
        ];
        $completedSubjects = UserSubject::whereIn('subject_id', $subjectIds)->where($filter)->get();

        if (count($subjectIds) == count($completedSubjects)) {
            $updatedData = [
                'end_date' => date("Y-m-d H:i:s"),
                'status' => config('common.user_course.status.finish')
            ];
            UserCourse::where(['course_id' => $courseSubject['course_id'], 'user_id' => Auth::user()->id])->update($updatedData);

            $course = Course::find($courseSubject['course_id']);
            $eventData = [
                'type' => config('common.activity.type.finish_course'),
                'course_id' => $course['id'],
                'name' => $course['name'],
            ];
            event(new CourseActivity($eventData));
        }

        return $courseSubject;
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        $data['subject'] = $data->subject;
        $courseSubject = CourseSubject::where('subject_id', $data['subject']['id'])->first();
        $data['course'] = Course::find($courseSubject['course_id']);

        return $data;
    }

    public function addTask($request)
    {
        $subjectId = $request->subjectId;
        $task = [
            'subject_id' => $subjectId,
            'name' => $request->name,
            'description'=> $request->description,
        ];

        try {
            $userIds = UserSubject::where('subject_id', $subjectId)
                ->where('status', config('common.subject.status.start'))
                ->lists('user_id');
            DB::beginTransaction();
            $createTask = Task::create($task);
            $taskId = $createTask->id;
            $userTasks = [];

            if (count($userIds)) {
                foreach ($userIds as $userId) {
                    $userTasks[] = [
                        'user_id' => $userId,
                        'task_id' => $taskId,
                        'status' => config('common.subject.status.start'),
                    ];
                }

                $userTask = UserTask::insert($userTasks);
            }

            DB::commit();

            return $createTask;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addUserTask($input)
    {
        $data = UserTask::create($input);

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }
}
