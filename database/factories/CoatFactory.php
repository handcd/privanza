<?php

use Faker\Generator as Faker;

$factory->define(App\Coat::class, function (Faker $faker) {
    return [
        'order_id' => App\Order::all()->random()->id,
        // Saco - Externo
        'tipo_solapa' => rand(0,1), // 0pico/1escuadra
        'tipo_ojal_solapa' => rand(0,2), // 0al tono/1en contraste/2activo
        'color_ojal_solapa' => $faker->colorName,
        'botones_frente' => rand(1,6), // 1,2,3,6
        'aberturas_detras' => rand(0,2), // 0,1,2
        'botones_mangas' => rand(1,4), // 1-4
        'tipo_ojal_manga' => rand(0,3), // al tono/en contraste/activos
        'color_ojal_manga' => $faker->colorName,
        'posicion_ojal_manga' => rand(0,1), // 0 Cascada, 1 en línea
        'ojales_activos_manga' => rand(0,1), 
        'bolsa_parche' => rand(0,1),
        'bolsa_cartera' => rand(0,1),
        'bolsa_cartera_diagonal' => rand(0,1),
        'bolsa_vivo' => rand(0,1),
        'bolsa_vivo_diagonal' => rand(0,1),
        'bolsa_cartera_continental' => rand(0,1),
        'bolsa_cartera_continental_diagonal' => rand(0,1),
        'sin_bolsas' => rand(0,1),
        'pickstitch' => rand(0,1),
        'pickstitch_filos' => rand(0,1),
        'pickstitch_aletillla' => rand(0,1),
        'pickstitch_cartera' => rand(0,1),
        'sin_aletilla' => rand(0,1),

        // Saco - Interno
        'tipo_vista' => rand(0,1), // 0 normal / 1 chapeta francesa
        'balsam_rayas' => rand(0,1),
        'forro_interno_mangas' => $faker->colorName,
        'intern_pin_point' => rand(0,1),
        'pin_point_interno_color' =>  $faker->colorName,
        'pin_point_interno_codigo' => $faker->hexcolor,
        'bies' => rand(0,1),
        'color_bies' => $faker->colorName,
        'codigo_bies' => $faker->hexColor,
        'puntada_color' => $faker->colorName,
        'bolsa_interna_pecho_derecho' => rand(0,1),
        'bolsa_interna_pecho_izquierdo' => rand(0,1),
        'bolsa_interna_cigarrera' => rand(0,1),
        'bolsa_interna_plumera' => rand(0,1),
        'bolsa_int_color' => $faker->colorName,
        'vivos_bolsas_internas_cuerpo' => rand(0,1),
        'otro_vivos_bolsas_internas' => $faker->word,
        'puntada_filos' => rand(0,1),
        'puntada_aletillas' => rand(0,1),
        'puntada_carteras' => rand(0,1),
    ];
});
