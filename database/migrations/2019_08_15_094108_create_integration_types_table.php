<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integration_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('Название интеграции');
            $table->string('slug');
            $table->integer('user_can_create')->comment('Может ли пользователь сам создавать интеграции этого типа');
            $table->json('fields')->nullable()->comment('Поля для создания интеграции');
            $table->json('options')->nullable()->comment('Поля для добавления интеграции в канал');
        });

        Schema::create('integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('пользователь создавший интеграцию');
            $table->integer('type_id')->comment('тип интеграции');
            $table->string('name')->nullable()->comment('Название интеграции(имя группы или что-то такое)');
            $table->json('fields')->comment('значения для fields из integration_type');
        });

        Schema::create('integrations_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id');
            $table->integer('integration_id');
            $table->json('data')->comment('значения для options из integration_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integration_types');
        Schema::dropIfExists('integrations');
        Schema::dropIfExists('integrations_channels');
    }
}
