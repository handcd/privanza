<?php

use Faker\Generator as Faker;

$factory->define(App\Pants::class, function (Faker $faker) {
    return [
        // Datos Generales
        'order_id' => App\Order::all()->random()->id,
        'notas' => $faker->text($maxNbChars = 200),

        // Clothing
        'pase' => rand(0,1), // 0 Con pase, 1 Sin Pase
        'pliegues' => rand(0,2), // 0-2
        'bolsas_traseras' => rand(0,2),
        'tipo_vivo' => rand(1,2), // 1 Vivo Doble con Ojal, 2 Vivo Sencillo con Ojal
        'color_ojalera' => $faker->colorName,
        'color_medio_forro' => $faker->colorName,
        'dobladillo' => rand(1,2), // 1 normal, 2 valenciana

        // Medidas Corporales
        'fit_id' => 2,
        'talla' => 42,
        'largo_ext' => 42.4,
        'largo_int' => 38.3,
	];
});
