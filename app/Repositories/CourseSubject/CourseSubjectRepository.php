<?php

namespace App\Repositories\CourseSubject;

use App\Models\CourseSubject;
use App\Repositories\BaseRepository;
use Exception;
use DB;

class CourseSubjectRepository extends BaseRepository implements CourseSubjectRepositoryInterface
{
    function __construct(CourseSubject $courseSubject)
    {
        $this->model = $courseSubject;
    }
}
