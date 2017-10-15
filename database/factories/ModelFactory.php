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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'is_admin' => randomElement(['admin','user']),
    ];
});
$factory->define(App\Profile::class, function (Faker\Generator $faker) {


    return [
        'user_id' => $faker->numberBetween(0,10),
        'name' => $faker->name,
        'lastname' => $faker->name,
        'middlename' => $faker->name,
        'title' => $faker->sentence(3),
    ];
});
$factory->define(App\Project::class, function (Faker\Generator $faker) {


    return [
        'user_id' => $faker->numberBetween(0,10),
        'title' => $faker->name,
        'resource_id' => $faker->numberBetween(1,20),
        'duration' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement(['on_hold','in_process','done','discard']),
        'type' => $faker->randomElement(['upgrade','fix','experimental','new','schedule']),
        'starts_at' => $faker->unixTime($max = 'now'),
    ];
});
$factory->define(App\Checkpoint::class, function (Faker\Generator $faker) {


    return [
        'title' => $faker->name,
        'project_id' => $faker->numberBetween(1,10),
        'resource_id' => $faker->numberBetween(1,10),
        'estimated_duration' => $faker->numberBetween(1,10),
        'real_duration' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement(['on_hold','in_process','done','discard']),
    ];
});
$factory->define(App\Resource::class, function (Faker\Generator $faker) {


    return [
        'name' => $faker->name,
        'lastname' => $faker->name,
        'middlename' => $faker->name,
        'title' => $faker->sentence(1),
        'phone' => $faker->sentence(1),
        'email' => $faker->sentence(1),
        'birthdate' => $faker->sentence(1),
        'owner_id' => $faker->numberBetween(1,5),
    ];
});

