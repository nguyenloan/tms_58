<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use Exception;
use Auth;
use Request;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function updateTaskStatus($input, $ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $key => $id) {
                $data = UserTask::where('id', $id)->update($input[$key]);
            }
        } else {
            $data = UserTask::where('id', $ids)->update($input);
        }

        if (!$data) {
            throw new Exception(trans('general/message.update_error'));
        }

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

    public function store($inputs)
    {
        $data = $this->model->insert($inputs);

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }
}
