<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastBroadcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast__broadcasts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('title', 30);
            $table->string('gender')->nullable()->default('male')
                ->comment('value: male/female for Male/Female');
            
            $table->string('age_band')->nullable()
                ->comment('18_25, 26_35, 36_50, above_50');
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
        Schema::dropIfExists('broadcast__broadcasts');
    }
}
