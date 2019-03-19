<?php

use Illuminate\Database\Seeder;

class AttachmentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Channels\Attachment::class, 20)->create();
    }
}
