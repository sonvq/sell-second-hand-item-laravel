<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppuserActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appuser__activity', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('appuser_id')->unsigned()->nullable();
            $table->string('action');
            $table->integer('item_id')->unsigned()->nullable();
            $table->timestamp('log_time')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appuser__activity');
    }
}
