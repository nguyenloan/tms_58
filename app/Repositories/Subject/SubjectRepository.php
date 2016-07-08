<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
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
            throw new Exception("general/message.subject_empty");
        }

        $userSubject = UserSubject::where(['user_id' => Auth::user()->id, 'subject_id' => $id])->first();

        if (!count($userSubject)) {
            $userSubject = [
                'user_id' => Auth::user()->id,
                'subject_id' => $id,
                'status' => 0,
                'start_date' => date("Y-m-d H:i:s")
            ];
            UserSubject::create($userSubject);
            $userSubject['status'] = trans('general/label.training');
        }
        $tasks = Task::where('subject_id', $id)->get();

        if (!count($tasks)) {
            throw new Exception("general/message.task_empty");
        }

        foreach ($tasks as $key => $task) {
            $userTask = UserTask::where(['user_id' => Auth::user()->id, 'task_id' => $task['id']])->first();

            if (!count($userTask)) {
                $userTask = [
                    'user_id' => Auth::user()->id,
                    'task_id' => $task['id'],
                    'status' => 0
                ];
                UserTask::create($userTask);
                $userTask['status'] = trans('general/label.training');
            }

            $tasks[$key]['status'] = $userTask['status'];
        }
        $subject['tasks'] = $tasks;

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

