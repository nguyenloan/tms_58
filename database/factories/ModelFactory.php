<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'role' => 0,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Subject::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Subject_' . rand(1, 1000),
        'description' => $faker->paragraph(5),
    ];
});

$factory->define(App\Models\Course::class, function (Faker\Generator $faker) {
    return [
        'name' => 'course_' . rand(1, 1000),
        'description' => $faker->paragraph(5),
    ];
});

$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Task_' . rand(1, 1000),
        'description' => $faker->text,
        'subject_id' => rand(1, 48),
    ];
});
$factory->define(App\Models\Activity::class, function (Faker\Generator $faker) {
    return [
        'user_id' => \App\Models\User::all(),
        'description' => $faker->text,
        'subject_id' => rand(1, 48),
    ];
});
