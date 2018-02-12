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
        // Datos Saco
        'fit_saco' => 1,
        'talla_saco' => 30,
        'corte_saco' => 1,
        'largo_manga' => 30,
        'largo_espalda' => 38,
        'notas_saco' => $faker->text($maxNbChars = 200),
        // Datos Pantalón
        'fit_pantalon' => 2,
        'talla_pantalon' => 42,
        'largo_pantalon_ext' => 42.4,
        'largo_pantalon_int' => 38.3,
        'notas_pantalon' => $faker->text($maxNbChars = 200),
        // Datos Chaleco
        'fit_chaleco' => 3,
        'talla_chaleco' => 30,
        'corte_chaleco' => 3,
        'largo_espalda_chaleco' => 33,
        'notas_chaleco' => $faker->text($maxNbChars = 200),
        // Datos Generales
        'vendedor_id' => App\Vendedor::all()->random()->id,
        'contacto' => 'Batman',
    ];
});
