<?php

use Faker\Generator as Faker;
use App\Models\Channels\Attachment;
use App\Models\Channels\Message;

$factory->define(Attachment::class, function (Faker $faker) {
    return [
        'message_id' => $faker->randomElement(Message::all()->pluck('message_id')),
        'type' => $faker->randomElement([Attachment::TYPE_FILE,Attachment::TYPE_IMAGE]),
        'status' => $faker->randomElement([Attachment::STATUS_ACTIVE,Attachment::STATUS_DISABLE]),
        'options' => str_random(20),
    ];
});
