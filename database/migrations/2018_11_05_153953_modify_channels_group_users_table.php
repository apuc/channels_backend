<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyChannelsGroupUsersTable extends Migration
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
            $table->integer('channel_id')->nullable()->unsigned();
            $table->foreign('channel_id')->references('channel_id')->on('channel')->onDelete('CASCADE');
            $table->primary(['user_id', 'channels_group_id', 'channel_id'], 'channels_group_users_primary');
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
            $table->dropPrimary();
            $table->dropForeign('channels_group_users_channel_id_foreign');
            $table->dropColumn('channel_id');
            $table->primary(['user_id', 'channels_group_id']);
        });
    }
}
