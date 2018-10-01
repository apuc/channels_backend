<?php

use Illuminate\Database\Seeder;
use App\Models\Channels\Group;

class ChannelsGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 20)->create();
    }
}
