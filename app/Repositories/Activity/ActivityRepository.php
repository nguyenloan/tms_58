<?php
/**
 * Created by PhpStorm.
 * Word: luongs3
 * Date: 5/10/2016
 * Time: 11:55 AM
 */

namespace App\Repositories\Activity;

use App\Repositories\BaseRepository;
use App\Models\Activity;
use Auth;
use Exception;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface
{
    public function __construct(Activity $activity)
    {
        $this->model = $activity;
    }

    public function store($input)
    {
        $this->checkDuplicatedEvent($input);
        $data = [
            'user_id' => Auth::user()->id,
            'description' => $this->getDescription($input),
            'type' => $input['type']
        ];

        if (isset($input['subject_id'])) {
            $data['subject_id'] = $input['subject_id'];
        } else {
            $data['course_id'] = $input['course_id'];
        }

        $data = $this->model->create($data);

        return $data;
    }

    public function getDescription($input)
    {
        switch ($input['type']) {
            case config('common.activity.type.start_course'):
                return trans('general/message.start_course_activity', ['user' => Auth::user()->name]);
            case config('common.activity.type.finish_course'):
                return trans('general/message.finish_course_activity', ['user' => Auth::user()->name]);
            case config('common.activity.type.start_subject'):
                return trans('general/message.start_subject_activity', ['user' => Auth::user()->name, 'subject' => $input['subject']]);
            case config('common.activity.type.finish_subject'):
                return trans('general/message.finish_subject_activity', ['user' => Auth::user()->name, 'subject' => $input['subject']]);
        }
    }

    public function checkDuplicatedEvent($input)
    {
        if (isset($input['course_id'])) {
            $userActivity = $this->model->where(['user_id' => Auth::user()->id, 'course_id' => $input['course_id']])->count();
        } else {
            $userActivity = $this->model->where(['user_id' => Auth::user()->id, 'subject_id' => $input['subject_id']])->count();
        }

        if ($userActivity > 0) {
            throw new Exception(trans('general/message.duplicated_event'));
        }
    }

    public function userActivity()
    {
        $limit = config('common.user.activity_limit');
        $order = config('common.base_repository.order_by');
        $data = $this->model->where('user_id', Auth::user()->id)->orderBy($order['key'], $order['aspect'])->take($limit)->get();

        return $data;
    }
}
