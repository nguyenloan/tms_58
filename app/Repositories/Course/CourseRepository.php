<?php

namespace App\Repositories\Course;

use App\Repositories\BaseRepository;
use App\Models\Course;
use Exception;
use Auth;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function __construct(Course $course)
    {
        $this->model = $course;
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

        return $data;
    }
}
