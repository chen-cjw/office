<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\SendInviteSet::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'day' => rand(10,30),
        'requirement' => 3,
    ];
});
