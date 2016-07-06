<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create();
        factory(App\Models\Course::class, 50)->create()->each(function($u) {
            $u->subjects()->save(factory(App\Models\Subject::class)->make());
        });
        factory(App\Models\Subject::class, 50)->create()->each(function($u) {
            $u->tasks()->save(factory(App\Models\Task::class)->make());
        });
        factory(App\Models\Activity::class, 50)->create();
    }
}
