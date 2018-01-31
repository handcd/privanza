<?php

use Faker\Generator as Faker;

$factory->define(App\Validador::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('validador123'),
        'birthday' => $faker->dateTimeThisCentury,
        'job_position' => $faker->jobTitle,
        'enabled' => 1,
    ];
});
