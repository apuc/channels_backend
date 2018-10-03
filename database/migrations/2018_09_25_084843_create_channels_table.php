<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel', function (Blueprint $table) {
            $table->increments('channel_id');
            $table->string('title')->nullable();
            $table->string('slug');
            $table->string('status');
            $table->string('type');
            $table->boolean('private');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('channel_users', function (Blueprint $table) {
            $table->integer('user_id')->on('users')->onDelete('CASCADE');
            $table->integer('channel_id')->on('channel')->onDelete('CASCADE');
            $table->primary(['user_id', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel');
        Schema::dropIfExists('channel_users');
    }
}
