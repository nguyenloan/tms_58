<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Requests;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserSubject;
use Exception;
use Auth;
use App\Models\Course;
use App\Models\Subject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    private $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository, UserRepositoryInterface $userRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjectRepository->index('subjects');

        return view('subject.index', $subjects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $subject = $this->subjectRepository->userSubject($id);

            return view('subject.show', compact('subject'));
        } catch (Exception $ex) {
            return redirect()->route('subjects.index')->withError($ex->getMessage());
        }
    }
    public function subjectTask($id)
    {
        $subjectTask = $this->subjectRepository->userSubject($id);
        $userCurrent = $this->userRepository->find(Auth::user()->id);

        return view('user.task_subject', compact('subjectTask', 'userCurrent'));
    }
}
