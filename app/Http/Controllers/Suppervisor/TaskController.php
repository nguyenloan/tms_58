<?php

namespace App\Http\Controllers\Suppervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\CreateTaskRequest;

class TaskController extends Controller
{
    protected $taskRepository;
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        session()->keep(['subject_id']);
        $this->taskRepository = $taskRepository;
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
        return view('suppervisor.task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        $task = [
            'subject_id' => $request->subjectId,
            'name' => $request->name,
            'description'=> $request->description,
        ];

        try {
            $task = $this->taskRepository->store($task);

            return redirect()->action('Suppervisor\SubjectController@show', [$request->subjectId])->with([
                'message'=> trans('general/message.create_task_success')
            ]);
        } catch (Exception $e) {
            return redirect()->action('Suppervisor\SubjectController@show', [$request->subjectId])->withError($e->getMessage());
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
            $taskData = $this->taskRepository->find($id);

            return view('suppervisor.task.edit', [
                'task' => $taskData,
            ]);
        } catch (Exception $e) {
            return redirect()->action('Suppervisor\SujectController@show', [$request->subjectId])->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $taskInput = [
            'subject_id' => $request->subjectId,
            'name' => $request->name,
            'description' => $request->description,
        ];

        try {
            $taskUpdate = $this->taskRepository->update($taskInput, $id);

            return redirect()->action('Supervisor\SubjectController@show', [$request->subjectId])->with([
                'message' => trans('general/message.update_task_successfully')
            ]);
        } catch (Exception $e) {
            return rediect()->action('Suppervisor\SubjectController@show', [$request->subjectId])->withError($e->getMessage());
        }
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
