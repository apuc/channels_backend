<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarIdToChannelGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('avatar_id')->nullable();
        });

        Schema::table('channels_group', function (Blueprint $table) {
            $table->integer('avatar_id')->nullable();
        });

        Schema::table('channel', function (Blueprint $table) {
            $table->integer('avatar_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_id');
        });

        Schema::table('channels_group', function (Blueprint $table) {
            $table->dropColumn('avatar_id');
        });

        Schema::table('channel', function (Blueprint $table) {
            $table->dropColumn('avatar_id');
        });
    }
}
