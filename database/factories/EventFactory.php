<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
	$vendedor = App\Vendedor::all()->random();
    return [
        'vendedor_id' => $vendedor->id,
        'client_id' => $vendedor->clients->random()->id,
        'fechahora' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = '+1 month'),
    ];
});
