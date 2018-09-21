<?php

use Faker\Generator as Faker;
use App\Models\Channels\Group;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'title' => $title =  $faker->title(),
        'slug' => str_slug($title),
        'status' => $faker->randomElement([Group::STATUS_ACTIVE, Group::STATUS_DISABLE])
    ];
});
