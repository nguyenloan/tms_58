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
    public function __construct(Task $subject)
    {
        $this->model = $subject;
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
}

