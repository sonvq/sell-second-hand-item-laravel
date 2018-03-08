<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify__notifies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            
            $table->integer('sender_id')->unsigned()->nullable();
            $table->integer('receiver_id')->unsigned()->nullable();
            
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('message_type')->nullable();
            $table->boolean('is_new')->default(1);
            $table->boolean('is_read')->default(0);
            
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
        Schema::dropIfExists('notify__notifies');
    }
}
