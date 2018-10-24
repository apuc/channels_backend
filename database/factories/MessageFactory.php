<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 22.10.18
 * Time: 15:18
 */

use App\Models\Channels\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'channel_id' => $faker->randomElement(\App\Models\Channels\Channel::all()->pluck('channel_id')),
        'from' => $faker->randomElement(\App\Models\User::all()->pluck('user_id')),
        'to' => $faker->randomElement(\App\Models\User::all()->pluck('user_id')),
        'read' => $faker->randomElement([0,1]),
        'text' => $faker->text(200),
    ];
});