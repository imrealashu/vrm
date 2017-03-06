<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVRMMiddlewaresVrmRoutesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vrm_middlewares_vrm_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('middleware_id');
            $table->integer('route_id')->unsigned()->index();
            $table->foreign('route_id')->references('id')->on('vrm_routes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vrm_middlewares_vrm_routes');
    }
}