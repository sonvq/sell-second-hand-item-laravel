<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt__receipts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('appuser_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->integer('total_promo_days')->nullable()->default(0);
            
            $table->timestamp('promo_period_from')->nullable();
            $table->timestamp('promo_period_to')->nullable();
            
            $table->string('payment_mode')->default('otc')
                    ->comment('otc / bank_transfer / visa / master / paypal / mpu / mobile_payment');
            $table->string('transaction_type')->default('debit')
                    ->comment('debit / credit');
            
            $table->string('transaction_ref_id')->nullable();
            $table->text('remarks')->nullable();
            $table->float('amount_due', 12, 2)->nullable();
            
            $table->softDeletes();
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
        Schema::dropIfExists('receipt__receipts');
    }
}
