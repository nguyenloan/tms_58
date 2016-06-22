<?php
/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 1/30/2016
 * Time: 10:38 AM
 */

namespace App\Repositories;

use Exception;
use DB;

abstract class BaseRepository
{

    protected $model;

    public function index($subject, $options = [])
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.base_repository.limit');
        $order = isset($options['order']) ? $options['order'] : config('common.base_repository.order_by');
        $filter = isset($options['filter']) ? $options['filter'] : config('common.base_repository.filter');
        $data['rows'] = $this->model->where($filter)->orderBy($order['key'], $order['aspect'])->paginate($limit);

        if (count($data['rows']) === 0) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        $data['subject'] = $subject;
        $data['buttons'] = isset($options['buttons']) ? $options['buttons'] : config('common.base_repository.buttons');
        $data['columns'] = isset($options['columns']) ? $options['columns'] : $this->model->getFillable();
        $data['alerts'] = config('common.base_repository.alerts');
        $data['ids'] = [];
        foreach ($data['rows'] as $key => $row) {
            $data['ids'][$key] = $row['id'];
            $data['rows'][$key] = $row->where('id', $row['id'])->first($data['columns']);
        }

        return $data;
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new Exception(trans('general/message.item_not_exist'));
        }

        return $data;
    }

    public function store($input)
    {
        $data = $this->model->create($input);

        if ($data === 0) {
            throw new Exception(trans('general/message.create_error'));
        }

        return $data;
    }

    public function all($options = [])
    {
        $filter = isset($options['filter']) ? $options['filter'] : config('common.base_repository.filter');
        $attributes = isset($options['attributes']) ? $options['attributes'] : config('common.base_repository.attributes');
        $data = $this->model->where($filter)->get($attributes);

        if (count($data) === 0) {
            throw new Exception(trans('general/message.data_empty'));
        }

        return $data;
    }

    public function update($input, $id)
    {
        $data = $this->model->where('id', $id)->update($input);

        if ($data === 0) {
            throw new Exception(trans('general/message.update_error'));
        }

        return $id;
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            $data = $this->model->destroy($ids);

            if ($data === 0) {
                throw new Exception(trans('general/message.delete_error'));
            }

            DB::commit();

            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}