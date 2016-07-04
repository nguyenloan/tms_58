<?php

/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 5/10/2016
 * Time: 11:54 AM
 */
namespace App\Repositories\Activity;

interface ActivityRepositoryInterface
{
    public function index($subject, $options = []);
    public function show($id);
    public function store($data);
    public function all($options = []);
    public function update($data, $id);
    public function delete($id);
}