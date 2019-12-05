<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot', function (Blueprint $table) {
            $table->increments('bot_id');
            $table->string('name');
            $table->integer('owner_id');
            $table->integer('avatar_id')->nullable();
            $table->string('hook_url')->nullable();
        });

        Schema::create('bot_channel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id');
            $table->integer('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot');
        Schema::dropIfExists('bot_channel');
    }
}
