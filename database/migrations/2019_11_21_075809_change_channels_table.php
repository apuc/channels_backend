<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Channels\Channel;

class ChangeChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel', function (Blueprint $table) {
            $table->integer('to_id')->nullable()->comment('с кем диалог');
            $table->string('status')->default(Channel::STATUS_ACTIVE)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel', function (Blueprint $table) {
            $table->dropColumn('to_id');
            $table->string('status')->default(Channel::STATUS_ACTIVE)->change();
        });
    }
}
