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
        'altura' => $faker->randomFloat(2,0,50000),
        'peso' => $faker->randomFloat(2,0,50000),
        'edad' => $faker->randomNumber(),
        'hombros' => $faker->randomFloat(2,0,50000),
        'abdomen' => $faker->randomFloat(2,0,50000),
        'pecho' => $faker->randomFloat(2,0,50000),
        'espalda' => $faker->randomFloat(2,0,50000),
        'contornoCuello' => $faker->randomFloat(2,0,50000),
        'contornoBiceps' => $faker->randomFloat(2,0,50000),
        'medidaHombros' => $faker->randomFloat(2,0,50000),
        'brazoDerecho' => $faker->randomFloat(2,0,50000),
        'brazoIzquierdo' => $faker->randomFloat(2,0,50000),
        'hombroDerecho' => $faker->randomFloat(2,0,50000),
        'hombroIzquierdo' => $faker->randomFloat(2,0,50000),
        'anchoEspalda' => $faker->randomFloat(2,0,50000),
        'largoTorso' => $faker->randomFloat(2,0,50000),
        'contornoPecho' => $faker->randomFloat(2,0,50000),
        'punio' => $faker->randomFloat(2,0,50000),
        'contornoAbdomen' => $faker->randomFloat(2,0,50000),
        'contornoCintura' => $faker->randomFloat(2,0,50000),
        'contornoCadera' => $faker->randomFloat(2,0,50000),
        'largoTiro' => $faker->randomFloat(2,0,50000),
        'largoInternoPantalon' => $faker->randomFloat(2,0,50000),
        'largoExternoPantalon' => $faker->randomFloat(2,0,50000),
        'contornoMuslo' => $faker->randomFloat(2,0,50000),
        'contornoRodilla' => $faker->randomFloat(2,0,50000),
        // Datos Generales
        'vendedor_id' => App\Vendedor::all()->random()->id,
        'contacto' => 'Batman',
    ];
});
