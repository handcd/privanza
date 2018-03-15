<?php

use Faker\Generator as Faker;

$factory->define(App\Vest::class, function (Faker $faker) {
    return [
    	'order_id' => App\Order::all()->random()->id,
        'tipo_cuello' => rand(1,2), // 1 En V/2 Con Solapa
        'tipo_bolsas' => rand(0,1), // 0 Vivo/1 Aletilla
        'tipo_espalda' => rand(1,2), // 1 Forro/ 2 Tela
        'ajustador_espalda' => rand(0,1),

        // Datos Chaleco
        'fit_id' => 3,
        'talla_chaleco' => 30,
        'corte_chaleco' => 3,
        'largo_espalda_chaleco' => 33,
        'notes' => $faker->text($maxNbChars = 200),
    ];
});
