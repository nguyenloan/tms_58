<?php

namespace App\Http\Controllers\Trainee;

use Request;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use Exception;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function show($id)
    {
        try {
            $task = $this->taskRepository->show($id);

            return view('task.show', compact('task'));
        } catch (Exception $ex) {
            return redirect()->route('courses.index')->withError($ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->taskRepository->updateTaskStatus($id);
        } catch (Exception $ex) {
            return redirect()->route('courses.index')->withError($ex->getMessage());
        }

        return redirect()->route('subjects.show', ['id' => $data['subject_id']]);
    }

    public function ajaxUpdate(){
        $ids = request()->get('ids');

        try {
            $data = $this->taskRepository->updateTaskStatus($ids);
        } catch (Exception $ex) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
