<?php

use Illuminate\Database\Seeder;

class ChannelSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Channels\Channel::class, 100)->create();
    }
}
