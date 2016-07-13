<?php

namespace App\Http\Controllers\Suppervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\UserCourse\UserCourseRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use Session;

class UserCourseController extends Controller
{
    private $userCourseRepository;
    private $userRepository;
    private $courseRepository;

    public function __construct(
        UserCourseRepositoryInterface $userCourseRepository,
        UserRepositoryInterface $userRepository,
        CourseRepositoryInterface $courseRepository
    )
    {
        $this->userCourseRepository = $userCourseRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        session()->keep(['courseId']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courseId = session()->get('courseId');
        $course = $this->courseRepository->find($courseId);
        $listTrainees = $this->userRepository->listTrainee($courseId);

        return view('suppervisor.user_course.add_trainee', [
            'listTrainees' => $listTrainees,
            'course' => $course,
            'message' => count($listTrainees) ? '' : trans('general/message.item_not_exist'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userCourses = [];
        $courseId = session()->get('courseId');

        if (request()->has('ids')) {
            $traineeIds = request()->get('ids');
        }

        try {
            $dataCourse = $this->userCourseRepository->addTrainee($traineeIds, $courseId);

            return response()->json(['success' => true]);
        } catch (Exception $ex) {
            return response()->json(['success' => $ex->getMessage()]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
