<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeChannelsGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels_group_users', function (Blueprint $table) {
            $table->dropPrimary();
        });

        Schema::table('channels_group_users', function (Blueprint $table) {
            $table->integer('channels_group_id')->nullable()->change();
            $table->primary(['user_id', 'channel_id'], 'channels_group_users_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels_group_users', function (Blueprint $table) {
            $table->integer('channels_group_id')->change();
        });
    }
}
