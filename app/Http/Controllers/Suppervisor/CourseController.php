<?php

namespace App\Http\Controllers\Suppervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\AddSuppervisorRequest;
use Exception;

class CourseController extends Controller
{
    private $courseRepository;
    private $userRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = $this->courseRepository->index('courses');

        return view('suppervisor.course.index', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppervisor.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateCourseRequest $request)
    {
        $course = [
            'name' => $request->name,
            'description' => $request->description
        ];

        try {
            $data = $this->courseRepository->store($course);

            return redirect()->route('admin.courses.index')->with([
                'message' => trans('settings.create_success')
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.courses.index')->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->courseRepository->find($id);

        return view('suppervisor.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $course = $this->courseRepository->find($id);
            session()->flash('courseId', $id);

            return view('suppervisor.course.edit', [
                'course' => $course
            ]);
        } catch (Exception $e) {

            return redirect()->route('admin.courses.index')->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $courseInput = [
            'name' => $request->name,
            'description' => $request->description
        ];

        try {
            $course = $this->courseRepository->update($courseInput, $id);

            return redirect()->route('admin.courses.index')->with([
                'message' => trans('settings.edit_success')
            ]);
        } catch (Exception $e) {

            return redirect()->route('admin.courses.index')->withError($e->getMessage());
        }
    }
    public function addSuppervisor($id)
    {
        $suppervisor = $this->userRepository->listSupervisor();
        $course = $this->courseRepository->find($id);

        return view('suppervisor.course.add_supper', compact('course', 'suppervisor'));
    }

    public function createSupper(AddSuppervisorRequest $request)
    {
        $newSuppervisor = [
            'user_id' => $request->user_id,
            'course_id' => $request->course_id
        ];

        try {
            $data = $this->courseRepository->addSuppervisor($newSuppervisor);

            return redirect()->route('admin.courses.index')->with([
                'message' => trans('settings.create_success')
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.courses.index')->withError($e->getMessage());
        }
    }

    public function traineeProgress($id)
    {
        try {
            $data = $this->courseRepository->traineeProgress($id);

            return view('suppervisor.course.trainee_progress', $data);
        } catch (Exception $e) {
            return redirect()->route('admin.courses.index')->withError($e->getMessage());
        }

    }
}
