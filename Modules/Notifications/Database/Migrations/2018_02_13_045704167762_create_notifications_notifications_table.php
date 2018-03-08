<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications__notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('name', 255);
            $table->integer('broadcast_id')->unsigned()->nullable();
            $table->string('status')
                    ->comment('scheduled / published / draft')
                    ->default('draft');
            
            $table->string('channels')
                    ->comment('sms / email / in_app_notification')
                    ->default('in_app_notification');
            
            $table->date('schedule_date_from')->nullable();
            $table->date('schedule_date_to')->nullable();
            
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
        Schema::dropIfExists('notifications__notifications');
    }
}
