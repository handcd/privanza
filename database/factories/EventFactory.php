<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'vendedor_id' => App\Vendedor::random()->id,
        'client_id' => App\Vendedor::find($vendedor)->clients->random()->id,
        'fechahora' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = '+1 month'),
    ];
});
