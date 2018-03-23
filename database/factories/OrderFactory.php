<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'client_id' => App\Client::all()->random()->id,
        'vendedor_id' => App\Vendedor::all()->random()->id,
        'precio' => $faker->randomFloat(2,0,50000),
        //Contenido de Orden
        'has_vest' => rand(0,1),
        'has_coat' => rand(0,1),
        'has_pants' => rand(0,1),
        // Status General de Orden
        'approved' => rand(0,1),
        'date_approved' => $faker->dateTimeBetween('-1 month','-3 weeks'),
        'production' => rand(0,1),
        'date_production' => $faker->dateTimeBetween('-3 weeks','-2 weeks'),
        'pickup' => rand(0,1),
        'date_pickup' => $faker->dateTimeBetween('-2 weeks','-1 week'),
        'delivered' => rand(0,1),
        'date_delivered' => $faker->dateTimeBetween('-1 week','-3 days'),
        'facturado' => rand(0,1),
        'date_facturado' => $faker->dateTimeBetween('-3 days','-2 days'),
        'cobrado' => rand(0,1),
        'date_cobrado' => $faker->dateTimeBetween('-2 days','now'),
        // Status en Producción
        'corte' => rand(0,1),
        'date_corte' => $faker->dateTimeBetween('-3 weeks','-19 days'),
        'ensamble' => rand(0,1),
        'date_ensamble' => $faker->dateTimeBetween('-19 days','-17 days'),
        'plancha' => rand(0,1),
        'date_plancha' => $faker->dateTimeBetween('-17 days','-16 days'),
        'revision' => rand(0,1),
        'date_revision' => $faker->dateTimeBetween('-16 days','-2 weeks'),
        // // Etiquetado y Empaque
        'tela_isco' => rand(0,1),
        'codigo_tela' => $faker->word,
        'mts_tela_cliente' => $faker->randomFloat(1,1.5,5),
        'codigo_color_tela_cliente' => $faker->colorName,
        'forro_isco' => rand(0,1),
        'codigo_forro' => $faker->word,
        'mts_forro_cliente' => $faker->randomFloat(1,1.5,5),
        'codigo_color_forro_cliente' => $faker->hexcolor,
        'codigo_botones' => $faker->word,
        'color_botones' => $faker->colorName,
        'etiquetas_tela' => rand(0,1),
        'etiquetas_marca' => rand(0,1),
        'marca_en_etiqueta' => $faker->sentence(),
        'gancho' => rand(0,1),
        'gancho_personalizacion' => $faker->sentence(),
        'portatrajes' => rand(0,1),
        'portatrajes_personalizacion' => $faker->sentence(),
        'bordado' => $faker->sentence(),
        'letra' => $faker->sentence(),
        'bordadoColor' => $faker->sentence(),
        // 'notas_tela' => $faker->sentences(3),
    ];
});
