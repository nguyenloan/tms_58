<?php

namespace App\Http\Controllers\Suppervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateCourseRequest;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Models\Course;

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
        //
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

            return view('suppervisor.course.edit', [
                'course' => $course
            ]);
        } catch (Exception $e) {

            return redirect()->route('admin.course.index')->withError($e->getMessage());
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
}
