<?php

use Faker\Generator as Faker;

$factory->define(App\Vest::class, function (Faker $faker) {
    return [
        // Datos Generales
    	'order_id' => App\Order::all()->random()->id,
        'notas' => $faker->text($maxNbChars = 200),

        // Clothing
        'tipo_cuello' => rand(1,2),
        'tipo_bolsas' => rand(0,1),
        'tipo_espalda' => rand(1,2),
        'tipo_forro' => $faker->text(50),

        // Medidas Corporales
        'fit_id' => 3,
        'talla' => 30,
        'corte' => 2,
    ];
});
