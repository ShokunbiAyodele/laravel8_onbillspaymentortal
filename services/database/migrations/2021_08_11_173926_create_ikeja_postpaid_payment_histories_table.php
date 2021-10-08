<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkejaPostpaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikeja_postpaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('amount')->nullable();
            $table->string('utilityName')->nullable();
            $table->string('errorMessage')->nullable();
            $table->string('balance')->nullable();
            $table->string('status')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('ikeja_postpaid_payment_histories');
    }
}
