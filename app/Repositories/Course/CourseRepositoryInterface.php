<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function index($subject, $options = []);
    public function show($id = null);
    public function store($data);
    public function all($filters = []);
    public function update($data, $id);
    public function delete($id);
}
