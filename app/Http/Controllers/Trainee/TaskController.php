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
            return redirect()->route('subjects.index')->withError($ex->getMessage());
        }
    }

    public function update(Request $request, $ids)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
            foreach ($ids as $key => $id) {
                $input[$key] = ['status' => config('common.user_task.status.finish'), 'id' => $id];
            }
        } else {
            $input = ['status' => config('common.user_task.status.finish'), 'id' => $ids];
        }

        try {
            $data = $this->taskRepository->updateTaskStatus($input, $ids);
        } catch (Exception $ex) {
            return response()->json(['success' => $ex->getMessage()]);
        }

        return response()->json(['success' => true]);
    }

}
