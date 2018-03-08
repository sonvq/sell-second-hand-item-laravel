<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item__items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('appuser_id')->unsigned()->nullable();
            $table->string('title', 30);
            $table->string('description', 255);
            
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('subcategory_id')->unsigned()->nullable();
            
            $table->string('item_condition')
                    ->comment('mint/10/9/8/7/6/5/4/3/2/1 - Mint, 10 (Almost New), 9, 8, 7, 6, 5, 4, 3, 2, 1 (Bad Condition)')
                    ->default('mint');
            
            $table->string('price_currency')
                    ->comment('usd/mmk/hkd/cny/vnd/sgd - USD, MMK, HKD, CNY, VND, SGD')
                    ->default('mmk');
            
            $table->string('sell_status')
                    ->comment('selling / sold')
                    ->default('selling');
            
            $table->string('deliver')
                    ->comment('self_collection/delivery : Self Collection, Delivery')
                    ->default('self_collection');
            
            $table->float('price_number', 12, 2);
            $table->float('discount_price_number', 12, 2)->nullable();
            $table->float('discount_percent')->nullable();
            $table->string('meetup_location', 255);
            $table->boolean('featured')->default(0);
            
            $table->string('promote_method')
                    ->comment('social_promote / listing_promote')->nullable();
            $table->integer('promote_package')->unsigned()->nullable();
            
            $table->timestamp('featured_start_date')->nullable();
            $table->timestamp('featured_end_date')->nullable();
            
            $table->integer('accepted_offer_id')->unsigned()->nullable();
            
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            
            
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
        Schema::dropIfExists('item__items');
    }
}  