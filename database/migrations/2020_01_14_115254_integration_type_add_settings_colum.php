<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IntegrationTypeAddSettingsColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('integration_types',function (Blueprint $table){
            $table->json('settings')
                ->nullable()
                ->comment('Настройки для типа интеграций')
                ->after('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('integration_types',function (Blueprint $table){
            $table->dropColumn('settings');
        });
    }
}
