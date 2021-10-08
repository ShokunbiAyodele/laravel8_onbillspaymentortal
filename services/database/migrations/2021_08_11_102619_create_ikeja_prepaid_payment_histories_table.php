<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkejaPrepaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikeja_prepaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('amount')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('creditToken')->nullable();
            $table->string('tokenAmount')->nullable();
            $table->string('status')->nullable();
            $table->string('meternumber')->nullable();
            $table->string('utilityName')->nullable();
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
        Schema::dropIfExists('ikeja_prepaid_payment_histories');
    }
}
