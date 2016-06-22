<?php

/**
 * Created by PhpStorm.
 * User: luongs3
 * Date: 5/10/2016
 * Time: 11:54 AM
 */
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function index($subject, $options = []);
    public function show($id = null);
    public function store($data);
    public function all($filters = []);
    public function update($data, $id);
    public function delete($ids);
}