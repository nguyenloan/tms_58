<?php

namespace App\Http\Controllers\Suppervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use Exception;
use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Requests;

class SubjectController extends Controller
{
    private $subjectRepository;
    private $taskRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository, TaskRepositoryInterface $taskRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->taskRepository = $taskRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjectRepository->index('subjects');

        return view('suppervisor.subject.index', $subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppervisor.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubjectRequest $request)
    {
        $subject = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        try {
            $data = $this->subjectRepository->store($subject);
            $taskCount = $request->optionCount;
            $itemTasks = [];

            for ($i = 0; $i <= $taskCount; $i++) {
                if ($request->has('name-' . $i)) {
                    $itemTasks[] = [
                        'name' => $request->get('name-' . $i),
                        'description' => $request->get('description-' . $i),
                        'subject_id' => $data->id,
                    ];
                }
            }

            $dataTask = $this->taskRepository->store($itemTasks);

            return redirect()->route('admin.subjects.index')->with([
                'message' => trans('general/message.create_subject_success')
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.subjects.index')->withError($e->getMessage());
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
        $subject = $this->subjectRepository->show($id);

        return view('suppervisor.subject.show', [
            'subject' => $subject,
            'message' => count($subject['tasks']) ? '' : trans('general/message.item_not_exist'),
        ]);
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
            $subject = $this->subjectRepository->find($id);

            return view('suppervisor.subject.edit', [
                'subject' => $subject
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.subjects.index')->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, $id)
    {
        $subjectInput = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        try {
            $subject = $this->subjectRepository->update($subjectInput, $id);

            return redirect()->route('admin.subjects.index')->with([
                'message' => trans('general/message.update_subject')
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.subjects.index')->withError($e->getMessage());
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
        if (request()->has('ids')) {
            $id = request()->get('ids');
        }

        try {
            $data = $this->subjectRepository->delete($id);
        } catch (Exception $e) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('general/message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function editTask($id)
    {
        $subject = $this->subjectRepository->show($id);
        session()->flash('subjectId', $id);

        return view('suppervisor.subject.editTask', [
            'subject' => $subject,
            'message' => count($subject['tasks']) ? '' : trans('general/message.item_not_exist'),
        ]);
    }
}
