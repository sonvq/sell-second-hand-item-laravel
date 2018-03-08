<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppuserAppusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appuser__appusers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            // Your fields
            $table->string('username');
            $table->string('full_name')->nullable();
            $table->string('email');
            $table->string('phone_number');           
            
            $table->string('gender')->nullable()->default('male')
                ->comment('value: male/female for Male/Female');
            $table->date('date_of_birth')->nullable();
            
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            
            $table->string('password');                        
           
            $table->boolean('push_notification')->default(1);
            $table->boolean('first_time_login')->default(1);            
            
            $table->string('status')->comment('active/inactive')->default('active');
            
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
        Schema::dropIfExists('appuser__appusers');
    }
}
