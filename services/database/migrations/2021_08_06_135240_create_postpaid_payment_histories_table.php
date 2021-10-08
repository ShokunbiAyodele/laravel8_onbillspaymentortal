<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostpaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postpaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber');
            $table->string('status')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('externalReference')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('transactionStatus')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('user_id')->nullable()->comment('user_id = id in usertable');
            $table->string('requestId')->nullable();
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
        Schema::dropIfExists('postpaid_payment_histories');
    }
}
