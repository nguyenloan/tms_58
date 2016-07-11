<?php

namespace App\Http\Controllers\Suppervisor;

use App\Http\Controllers\Controller;
use Exception;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Activity\ActivityRepositoryInterface;

class TraineeController extends Controller
{
    private $userRepository;
    private $courseRepository;
    private $activityRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CourseRepositoryInterface $courseRepository,
        ActivityRepositoryInterface $activityRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->activityRepository = $activityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = [
            'filter' => ['role' => config('common.user.role.trainee')],
            'columns' => ['name', 'email', 'role'],
        ];
        $trainees = $this->userRepository->index('trainees', $options);

        return view('suppervisor.trainee.index', $trainees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppervisor.trainee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $trainee = $request->only('name', 'email', 'password');
        $trainee['avatar'] = config('common.user.default_avatar');
        $trainee['role'] = config('common.user.role.trainee');

        try {
            $data = $this->userRepository->store($trainee);

            return redirect()->route('admin.trainees.index')->withSuccess(trans('general/message.create_user_successfully'));
        } catch (Exception $e) {
            return redirect()->route('admin.trainees.index')->withError($e->getMessage());
        }
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
            $user = $this->userRepository->show($id);
            $courses = $this->courseRepository->userCourses($id);
            $activities = $this->activityRepository->userActivity();

            return view('suppervisor.trainee.show', compact('user', 'courses', 'activities'));
        } catch (Exception $ex) {
            return redirect()->route('courses.index')->withError($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $trainee = $this->userRepository->show($id);

            return view('suppervisor.trainee.edit', compact('trainee'));
        } catch (Exception $e) {
            return redirect()->route('admin.trainees.index')->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->only(['email', 'name', 'image_hidden']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        try {
            $data = $this->userRepository->update($data, $id);

            return redirect()->route("admin.trainees.index")->withSuccess(trans('general/message.edit_user_successfully'));
        } catch (Exception $ex) {
            return redirect()->route("admin.trainees.index")->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->has('ids')) {
            $id = request()->get('ids');
        }

        try {
            $data = $this->userRepository->delete($id);
        } catch (Exception $ex) {
            session()->flash('error', $ex->getMessage());

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('general/message.delete_successfully'));

        return response()->json(['success' => true]);
    }
}
