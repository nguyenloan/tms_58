<?php

namespace App\Repositories\CourseSubject;

use App\Models\CourseSubject;
use App\Repositories\BaseRepository;
use Exception;
use DB;

class CourseSubjectRepository extends BaseRepository implements CourseSubjectRepositoryInterface
{
    public function __construct(CourseSubject $courseSubject)
    {
        $this->model = $courseSubject;
    }

    public function create($subjectIds, $courseId)
    {
        $courseSubjects = [];

        foreach ($subjectIds as $subjectId) {
            $courseSubjects[] = [
                'course_id' => $courseId,
                'subject_id' => $subjectId,
            ];
        }

        $data = $this->model->insert($courseSubjects);

        return $data;
    }
}
