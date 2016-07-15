<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user = factory(App\Models\User::class)->make([
            'name' => 'Abigail',
            'email' => 'kak@gmail.com',
            'password' => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
            'role' => config('common.user.role.trainee'),
            'avatar' => config('common.user.default_avatar'),
        ]);
    }
}
