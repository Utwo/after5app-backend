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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'workplace' => $faker->company,
        'twitter' => $faker->colorName,
        'website' => $faker->url
    ];
});


$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->text(rand(10, 15)),
        'description' => $faker->sentence,
        'positions' => json_decode('[{"position_name": "' . $faker->word . '", "description": "' . $faker->sentence() . '"}, {"position_name": "' . $faker->word . '", "description": "' . $faker->sentence() . '"}]'),
        'application_questions' => json_decode('["' . $faker->sentence() . '" ]'),
        'status' => $faker->boolean(),
        'user_id' => \App\User::all()->random(1)->id
    ];
});

$factory->define(App\Skill::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(App\Application::class, function (Faker\Generator $faker) {
    return [
        'message' => $faker->sentence(),
        'answers' => json_decode('[{"question": "' . $faker->sentence() . '", "text": "' . $faker->sentence() . '"}]'),
        'user_id' => \App\User::all()->random(1)->id,
        'project_id' => \App\Project::all()->random(1)->id,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->sentence(),
        'user_id' => \App\User::all()->random(1)->id,
        'project_id' => \App\Project::all()->random(1)->id,
    ];
});