<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppuserForgotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appuser__forgot', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('appuser_id')->unsigned()->nullable();
            $table->string('token', 255);
            $table->string('status', 255)->comment('pending/completed')->default('pending');
            $table->timestamp('completed_at')->nullable();
            
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
        Schema::dropIfExists('appuser__forgot');
    }
}
