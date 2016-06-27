<?php

namespace App\Repositories\Subject;

interface SubjectRepositoryInterface
{
    public function index($subject, $options = []);

    public function show($id = null);

    public function all($options = []);

    public function store($input);

    public function update($input, $id);

    public function delete($ids);
}
