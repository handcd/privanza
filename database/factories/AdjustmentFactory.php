<?php

use Faker\Generator as Faker;

$factory->define(App\Adjustment::class, function (Faker $faker) {
    return [
        'promesa_planta' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'promesa_cliente' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'precio' => $faker->randomFloat(2,0,50000),
        'num_prendas' => rand(1,10),
        'descripcion' => $faker->text($maxNbChars = 200),
        'tipo_prenda' => $faker->word(),
        'adjustment_order_id' => App\AdjustmentOrder::all()->random()->id,
    ];
});
