<?php

namespace App\Repositories\Task;

interface TaskRepositoryInterface
{
    public function index($subject, $options = []);

    public function show($id = null);

    public function all($options = []);

    public function store($input);

    public function update($input, $id);

    public function delete($ids);
}
