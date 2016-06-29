<?php

namespace App\Repositories\Course;

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

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception('general/message.item_not_exist');
        }

        $data['tasks'] = $data->tasks;

        return  $data;
    }

    public function addSuppervisor($input)
    {
        $data = UserCourse::create($input);

        if (!$data) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }
}
