<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVRMRoutesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vrm_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prefix_id')->nullable();
            $table->integer('middlewares_group_id');
            $table->string('where')->nullable();
            $table->string('domain')->nullable();
            $table->string('path');
            $table->string('full_path');
            $table->string('as');
            $table->string('controller_id');
            $table->string('action');
            $table->string('method');

            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vrm_routes');
    }
}