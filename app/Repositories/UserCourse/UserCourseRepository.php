<?php

namespace App\Repositories\UserCourse;

use App\Repositories\BaseRepository;
use Exception;
use App\Models\UserCourse;

class UserCourseRepository extends BaseRepository implements UserCourseRepositoryInterface
{
    public function __construct(UserCourse $userCourse)
    {
        $this->model = $userCourse;
    }

    public function store($inputs)
    {
        $data = $this->model->insert($inputs);

        return $data;
    }
}
