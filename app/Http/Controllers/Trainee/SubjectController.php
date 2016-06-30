<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Requests;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Exception;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    private $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
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
}
