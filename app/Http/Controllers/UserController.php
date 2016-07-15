<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Auth;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Activity\ActivityRepositoryInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Request;
use App\Http\Requests\RegisterRequest;
use Response;
use Requests;
use App\Models\User;
use Socialite;

class UserController extends Controller
{
    private $userRepository;
    private $courseRepository;
    private $activityRepository;

    public function __construct(UserRepositoryInterface $userRepository, CourseRepositoryInterface $courseRepository, ActivityRepositoryInterface $activityRepository)
    {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->activityRepository = $activityRepository;
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
            $activities = $this->activityRepository->userActivity($id);

            return view('user.show', compact('user', 'courses', 'activities'));
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
        if ($id != Auth::user()->id) {
            return redirect()->route('users.show', ['id' => Auth::user()->id])->withError(trans('general/message.access_error'));
        }

        try {
            $user = $this->userRepository->show($id);

            return view('user.edit', compact('user'));
        } catch (Exception $ex) {
            return redirect()->route('users.show')->withError($ex->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
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

            return redirect()->route("users.edit", ['id' => $id])->withSuccess(trans('general/message.edit_user_successfully'));
        } catch (Exception $ex) {
            return redirect()->route("users.edit", ['id' => $id])->withError($ex->getMessage());
        }
    }

    public function calendarUser()
    {
        $calendarUser = $this->courseRepository->userCourses(Auth::user()->id);

        return view('user.user_calendar', compact('calendarUser'));
    }

    public function login(LoginRequest $request)
    {
        if ($request->ajax()) {
            $auth = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($auth)) {
                return Response::json(['success' => true, 'url' => route('home')]);
            }

            return Response::json(['success' => false, 'messages' => trans('settings.fails_account')]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function register(RegisterRequest $request)
    {
        if ($request->ajax()) {
            $userRegister = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => config('common.user.role.trainee'),
                'avatar' => config('common.user.default_avatar'),
            ];

            $authUser = User::create($userRegister);
            Auth::login($authUser);

            return Response::json(['success' => true, 'url' => route('home')]);
        }
    }

    public function redirectToProvider($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social)
    {
        $user = Socialite::driver($social)->user();
        if ($user) {
            $authUser = User::where('email', $user->getEmail())->first();
            if (!$authUser) {
                $authUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'avatar' => $user->getAvatar(),
                    'role' => config('common.user.role.trainee')
                ]);
            }
            Auth::login($authUser);
        }
        return redirect()->route('home');
    }
}
