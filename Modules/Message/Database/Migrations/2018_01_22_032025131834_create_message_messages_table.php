<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message__messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('seller_id')->unsigned()->nullable();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            
            $table->string('seller_visibility')->default('visible')->comment('visible / hidden');
            $table->string('buyer_visibility')->default('visible')->comment('visible / hidden');
            
            $table->string('chat_url')->nullable()->comment('Chat url from sendBird chat group');
            
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
        Schema::dropIfExists('message__messages');
    }
}
