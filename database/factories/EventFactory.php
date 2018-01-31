<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
	$vendedor = $faker->numberBetween($min = 1, $max = 20);
    return [
        'vendedor_id' => $vendedor,
        'client_id' => App\Vendedor::find($vendedor)->clients->random()->id,
        'fechahora' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = '+1 month'),
    ];
});
