<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_group', function (Blueprint $table) {
            $table->increments('channels_group_id');
            $table->string('title')->nullable();
            $table->string('slug');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('channels_group_users', function (Blueprint $table) {
            $table->integer('user_id')->on('users')->onDelete('CASCADE');
            $table->integer('channels_group_id')->on('channels_group')->onDelete('CASCADE');
            $table->primary(['user_id', 'channels_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels_group');
        Schema::dropIfExists('channels_group_users');
    }
}
