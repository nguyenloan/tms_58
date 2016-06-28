<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\BaseRepository;
use Exception;
use App\Models\Task;

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

        return  $data;
    }

    public function find($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception("general/message.item_not_exist");
        }

        return $data;
    }
}

