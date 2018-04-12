<?php

use Faker\Generator as Faker;

$factory->define(App\AdjustmentOrder::class, function (Faker $faker) {
    return [
        'client_id' => App\Client::all()->random()->id,
        'consecutivo_ajuste' => rand(1,100),
        'consecutivo_op' => App\Order::all()->random()->consecutivo_op,
        'status' => rand(0,2)
    ];
});
