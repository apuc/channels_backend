<?php

use App\Models\Channels\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'title' => $title =  $faker->title(),
        'slug' => str_slug($title),
        'type' => $faker->randomElement([Channel::TYPE_WALL, Channel::TYPE_CHAT]),
        'status' => $faker->randomElement([Channel::STATUS_ACTIVE, Channel::STATUS_DISABLE]),
        'private' => $faker->randomElement([0,1]),
    ];
});
