<?php

use Faker\Generator as Faker;

$factory->define(App\Coat::class, function (Faker $faker) {
    return [
        // Datos Generales
        'order_id' => App\Order::all()->random()->id,

        // Saco - Externo
        'tipo_solapa' => rand(0,1),
        'tipo_ojal_solapa' => rand(0,2),
        'ojal_activo_solapa' => rand(0,1),
        'color_ojal_solapa' => $faker->colorName,
        'botones_frente' => rand(1,6),
        'aberturas_detras' => rand(0,2),
        'botones_mangas' => rand(1,4),
        'tipo_ojal_manga' => rand(0,3),
        'color_ojal_manga' => $faker->colorName,
        'posicion_ojal_manga' => rand(0,1),
        'ojales_activos_manga' => rand(0,1),
        'posicion_ojales_activos_manga' => rand(0,2),
        'tipo_bolsas_ext' => rand(0,7),
        'pickstitch' => rand(0,1),
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
        'color_puntada' => $faker->colorName,
        'bolsas_int' => rand(0,3),
        'vivos_bolsas_internas_cuerpo' => rand(0,1),
        'otro_vivos_bolsas_internas' => $faker->word,
        'puntada_filos' => rand(0,1),
        'puntada_aletillas' => rand(0,1),
        'puntada_carteras' => rand(0,1),

        // Medidas Corporales
        'fit_id' => App\Fit::all()->random()->id,
        'talla' => rand(12,50),
        'notas_int' => $faker->text($maxNbChars = 200),
        'notas_ext' => $faker->text($maxNbChars = 200),
    ];
});
