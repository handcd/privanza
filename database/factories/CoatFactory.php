<?php

use Faker\Generator as Faker;

$factory->define(App\Coat::class, function (Faker $faker) {
    return [
        // Datos Generales
        'order_id' => App\Order::all()->random()->id,

        // Saco - Externo
        'tipo_solapa' => rand(0,1),
        'tipo_ojal_solapa' => rand(0,2),
        'color_ojal_solapa' => $faker->colorName,
        'botones_frente' => rand(1,6),
        'aberturas_detras' => rand(0,2),
        'botones_mangas' => rand(1,4),
        'tipo_ojal_manga' => rand(0,3),
        'color_ojal_manga' => $faker->colorName,
        'posicion_ojal_manga' => rand(0,1),
        'ojales_activos_manga' => rand(0,1), 
        'tipo_bolsas_ext' => rand(0,7),
        'pickstitch' => rand(0,1),
        'pickstitch_filos' => rand(0,1),
        'pickstitch_aletilla' => rand(0,1),
        'pickstitch_cartera' => rand(0,1),
        'sin_aletilla' => rand(0,1),

        // Saco - Interno
        'tipo_vista' => rand(0,1),
        'balsam_rayas' => rand(0,1),
        'forro_interno_mangas' => $faker->colorName,
        'pin_point_interno' => rand(0,1),
        'pin_point_interno_color' =>  $faker->colorName,
        'pin_point_interno_codigo' => $faker->hexcolor,
        'bies' => rand(0,1),
        'bies_color' => $faker->colorName,
        'bies_codigo' => $faker->hexColor,
        'puntada_color' => $faker->colorName,
        'bolsas_int' => rand(0,3),
        'bolsa_int_color' => $faker->colorName,
        'vivos_bolsas_internas_cuerpo' => rand(0,1),
        'otro_vivos_bolsas_internas' => $faker->word,
        'puntada_filos' => rand(0,1),
        'puntada_aletillas' => rand(0,1),
        'puntada_carteras' => rand(0,1),

        // Medidas Corporales
        'fit_id' => App\Fit::all()->random()->id,
        'talla' => rand(12,50),
        'corte' => rand(0,2),
        'largo_manga' => rand(10,40),
        'largo_espalda' => rand(10,40),
        'notas' => $faker->text($maxNbChars = 200),
    ];
});
