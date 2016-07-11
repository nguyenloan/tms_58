<?php

namespace App\Repositories\Subject;

use App\Models\CourseSubject;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use Exception;
use App\Models\Task;
use App\Models\UserSubject;
use Auth;
use DB;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function __construct(Subject $subject)
    {
        $this->model = $subject;
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception('general/message.item_not_exist');
        }

        $data['tasks'] = $data->tasks;

        return $data;
    }

    public function find($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception("general/message.item_not_exist");
        }

        return $data;
    }

    public function userSubject($id)
    {
        $subject = $this->model->find($id);

        if (!$subject) {
            throw new Exception(trans("general/message.subject_empty"));
        }

        $userSubject = UserSubject::where(['user_id' => Auth::user()->id, 'subject_id' => $id])->first();

        if (!count($userSubject)) {
            throw new Exception(trans("general/message.access_error"));
        }

        $userTasks = Auth::user()->load(['tasks' => function ($query) use ($id) {
            $query->where('tasks.subject_id', $id);
        }]);

        if (empty($userTasks->tasks)) {
            throw new Exception(trans("general/message.task_empty"));
        }

        $subject['pivot'] = $userSubject;
        $subject['tasks'] = $userTasks->tasks;

        foreach ($subject['tasks'] as $key => $task) {
            $subject['tasks'][$key]['status'] = $this->convertStatus($task->pivot->status);
        }

        return $subject;
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            $data = $this->model->destroy($ids);

            if (!$data) {
                throw new Exception(trans('general/message.delete_error'));
            }

            if (is_array($ids)) {
                $task = Task::whereIn('subject_id', $ids)->delete();
            } else {
                $task = Task::where('subject_id', $ids)->delete();
            }

            DB::commit();

            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listSubject()
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.base_repository.limit');
        $order = isset($options['order']) ? $options['order'] : config('common.base_repository.order_by');
        $filter = isset($options['filter']) ? $options['filter'] : config('common.base_repository.filter');
        $data = $this->model->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);

        return $data;
    }
}

