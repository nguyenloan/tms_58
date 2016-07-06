<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 5/10/2016
 * Time: 11:55 AM
 */

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Course;
use Exception;
use Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function update($input, $id)
    {
            $input['id'] = $id;

            $input = $this->uploadImage($input, $id);
            $data = $this->model->where('id', $id)->update($input);

            if ($data === 0) {
                throw new Exception(trans('general/message.update_error'));
            }

            return $data;
    }

    public function uploadImage($input, $id)
    {
        if (empty($input['image_hidden'])) {
            $input['avatar'] = null;

            if (isset($input['image'])) {

                if(!empty(Auth::user()->avatar) && Auth::user()->avatar != config('common.user.default_avatar')){
                    unlink(public_path(Auth::user()->avatar));
                }

                $destination = public_path(config('common.user.avatar_path'));
                $name = md5($id) . uniqid() . $input['image']->getClientOriginalName();
                $file = $input['image']->move($destination, $name);
                $checkError = $input['image']->getError();

                if ($checkError != "UPLOADERROK") {
                    throw new Exception(trans('general/message.file_error'));
                }

                $input['avatar'] = config('common.user.avatar_path') . $file->getFilename();
            }
        }
        unset($input['image_hidden']);
        unset($input['image']);

        return $input;
    }

    public function listSupervisor()
    {
        $data = $this->model->where('role', User::ROLE_SUPERVISOR)
            ->lists('name', 'id');

        return $data;
    }

    public function listTrainee($courseId)
    {
        $course = Course::findOrFail($courseId);
        $userCourse = $course->users->lists('id');

        $limit = isset($options['limit']) ? $options['limit'] : config('common.base_repository.limit');
        $order = isset($options['order']) ? $options['order'] : config('common.base_repository.order_by');
        $data = $this->model->where('role', User::ROLE_TRAINEE)
            ->whereNotIn('id', $userCourse)
            ->orderBy($order['key'], $order['aspect'])
            ->paginate($limit);

        return $data;
    }
}
