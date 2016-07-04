<?php

namespace App\Http\Controllers\Trainee;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Course\CourseRepositoryInterface;
use Exception;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    private $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = $this->courseRepository->index('courses');

        return view('course.index', $courses);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course = $this->courseRepository->show($id);

            return view('course.show', compact('course'));
        } catch (Exception $ex) {
            return redirect()->route('courses.index')->withError($ex->getMessage());
        }
    }

    public function trainees($courseId)
    {
        try {
            $course = $this->courseRepository->trainees($courseId);

            return view('course.trainee', compact('course'));
        } catch (Exception $ex) {
            return redirect()->route('courses.index')->withError($ex->getMessage());
        }
    }

    public function enroll($courseId)
    {
        try {
            $data = $this->courseRepository->enroll($courseId);

            return redirect()->route('courses.show', ['id' => $courseId])->withSuccess(trans('general/message.enroll_course_successfully'));
        } catch (Exception $ex) {
            return redirect()->route('courses.show', ['id' => $courseId])->withError($ex->getMessage());
        }
    }
}
