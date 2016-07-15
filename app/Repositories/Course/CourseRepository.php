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
use App\Models\CourseSubject;
use Exception;
use Auth;
use App\Models\User;
use App\Models\UserCourse;
use Collection;
use DB;

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
        $subjectIds = CourseSubject::where('course_id', $courseId)->lists('subject_id');

        if (count($subjectIds)) {
            // insert user subjects
            $subjects = [];
            foreach ($subjectIds as $subjectId) {
                $subjects[] = [
                    'user_id' => Auth::user()->id,
                    'subject_id' => $subjectId,
                    'status' => config('common.subject.status.start'),
                    'start_date' => date("Y-m-d H:i:s"),
                ];
            }
            UserSubject::insert($subjects);
            // insert user tasks
            $tasks = [];
            $taskIds = Task::whereIn('subject_id', $subjectIds)->lists('id');
            foreach ($taskIds as $taskId) {
                $tasks[] = [
                    'user_id' => Auth::user()->id,
                    'task_id' => $taskId,
                    'status' => config('common.user_task.status.training'),
                ];
            }
            UserTask::insert($tasks);
        }

        $input['name'] = $this->model->find($courseId)->name;
        $input['type'] = config('common.activity.type.start_course');

        event(new CourseActivity($input));

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
            $userTasks = $user->tasks()->whereIn('subject_id', $subjectIds)->get();

            if (count($userTasks)) {
                foreach ($userTasks as $userTask) {
                    $userTaskCount += $userTask->pivot->status;
                }
                $users[$key]['completed'] = round(($userTaskCount / $taskCount) * 100);
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

    public function subjectIds($courseId)
    {
        $subjectIds = $this->model->findOrFail($courseId)->subjects->pluck('id')->all();

        return collect($subjectIds);
    }

    public function delete($ids)
    {
        try {
            $subjectIds = CourseSubject::whereIn('course_id', $ids)->lists('subject_id');
            DB::beginTransaction();

            if (count($subjectIds)) {
                $taskIds = Task::whereIn('subject_id', $subjectIds)->lists('id');
                UserTask::whereIn('task_id', $taskIds)->delete();
                Task::whereIn('id', $taskIds)->delete();
            }

            UserSubject::whereIn('subject_id', $subjectIds)->delete();
            Subject::whereIn('id', $subjectIds)->delete();
            UserCourse::whereIn('course_id', $ids)->delete();
            CourseSubject::whereIn('course_id', $ids)->delete();
            $data = $this->model->destroy($ids);
            DB::commit();

            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateCourse($courseId, $newSubjectIds, $courseInput)
    {
        try {
            $courseSubjects = [];
            $userSubject = [];
            $userTask = [];
            $oldSubjectsInCourse = CourseSubject::where('course_id', $courseId)->lists('subject_id');
            $deletedSubjects = $oldSubjectsInCourse->diff($newSubjectIds);
            $newSubjects = collect($newSubjectIds)->diff($oldSubjectsInCourse);
            $tasks = Task::whereIn('subject_id', $newSubjects)->lists('id');
            $trainees = UserCourse::where('course_id', $courseId)
                ->where('status', config('common.user_course.status.start'))
                ->lists('user_id');

            if (count($newSubjects)) {
                foreach ($newSubjects as $subjectId) {
                    $courseSubjects[] = [
                        'course_id' => $courseId,
                        'subject_id' => $subjectId,
                    ];
                    foreach ($trainees as $trainee) {
                        $userSubject[] = [
                            'user_id' => $trainee,
                            'subject_id' => $subjectId,
                            'status' => config('common.subject.status.start'),
                        ];
                    }
                }
            }

            if (count($tasks)) {
                foreach ($tasks as $task) {
                    foreach ($trainees as $trainee) {
                        $userTask[] = [
                            'user_id' => $trainee,
                            'task_id' => $task,
                            'status' => config('common.subject.status.start'),
                        ];
                    }
                }
            }

            DB::beginTransaction();
            if (count($deletedSubjects)) {
                CourseSubject::whereIn('subject_id', $deletedSubjects)->delete();
                UserSubject::whereIn('subject_id', $deletedSubjects)->delete();
                $deletedTasks = Task::whereIn('subject_id', $deletedSubjects)->lists('id');
                UserTask::whereIn('task_id', $deletedTasks)->delete();
            }

            CourseSubject::insert($courseSubjects);
            UserSubject::insert($userSubject);
            UserTask::insert($userTask);

            $course = $this->model->where('id', $courseId)->update($courseInput);
            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function courseSubject($id)
    {
        $subjectIds = CourseSubject::where('course_id', $id)->lists('subject_id');

        return $subjectIds;
    }

    public function finishCourse($userIds, $id)
    {
        try {
            $updateStatus = [
                'end_date' => date('Y-m-d'),
                'status' => config('common.user_course.status.finish'),
            ];
            $updateTask = [
                'status' => config('common.user_course.status.finish'),
            ];


            DB::beginTransaction();
            $userCourse = UserCourse::where('course_id', $id)
                ->whereIn('user_id', $userIds)
                ->update($updateStatus);
            $subjectIds = $this->courseSubject($id);

            if (count($subjectIds)) {
                $taskIds = Task::whereIn('subject_id', $subjectIds)->lists('id');
                UserSubject::whereIn('subject_id', $subjectIds)
                    ->whereIn('user_id', $userIds)
                    ->update($updateStatus);

                if (count($taskIds)) {
                    UserTask::whereIn('task_id', $taskIds)
                        ->whereIn('user_id', $userIds)
                        ->update($updateTask);
                }
            }

            DB::commit();

            return $userCourse;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
