<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Task;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(4),
        'project_id' => factory(Project::class)
    ];
});
