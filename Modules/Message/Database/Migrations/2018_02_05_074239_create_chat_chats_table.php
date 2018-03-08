<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat__chats', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('message_id')->unsigned()->nullable();
            $table->integer('sender_id')->unsigned()->nullable();
            
            $table->text('message_content');
            $table->timestamp('sent_time')->nullable();
            $table->string('message_type')->nullable()->comment('message_type: image/text')
                ->default('text');
            
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
        Schema::dropIfExists('chat__chats');
    }
}
