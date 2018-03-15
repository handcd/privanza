<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {

    return [
        'name' => $faker->firstName,
        'lastname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address_visit' => $faker->streetAddress,
        'address_delivery' => $faker->streetAddress,
        'birthday' => $faker->dateTimeBetween($startDate = '-80 years', $endDate = '-15 years', $timezone = null),
        'notes' => $faker->text($maxNbChars = 200),
        // Datos Facturación
        'address_legal' => $faker->address,
        'rfc' => $faker->swiftBicNumber,
        'bank' => 'HSBC',
        'account_digits' => 1234,
        'concept' => $faker->text($maxNbChars = 200),
        
        // Datos Generales
        'vendedor_id' => App\Vendedor::all()->random()->id,
        'contacto' => 'Batman',
    ];
});
