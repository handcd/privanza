<?php

use Faker\Generator as Faker;

$factory->define(App\Vendedor::class, function (Faker $faker) {
	static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('testing'),
        'enabled' => 1,
        'name' => $faker->name,
        'lastname' => $faker->lastname,
        'phone' => $faker->phoneNumber,
        'birthday' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
        'address_home' => $faker->streetAddress,
        'address_legal' => $faker->streetAddress,
        'rfc' => $faker->swiftBicNumber,
        'account_digits' => 1234,
        'concept' => 'Venta de Trajes',
        'bank' => 'Banorte',
        'type' => 1,
        'remember_token' => str_random(10),
    ];
});
