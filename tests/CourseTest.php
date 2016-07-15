<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $users = factory(App\Models\User::class, 4)
           ->create()
           ->each(function ($u) {
                $u->courses()->save(factory(App\Models\Course::class)->make());
            });

        $users = factory(App\Models\User::class, 4)
           ->create()
           ->each(function ($u) {
                $u->courses()->save(factory(App\Models\Subject::class)->make());
            });

        $task = factory(App\Models\Task::class, function ($faker) {
            return [
                'name' => $faker->name,
                'description' => $faker->description,
                'subject_id' => function () {
                    return factory(App\Models\Subject::class)->create()->id;
                }
            ];
        });

    }
}
