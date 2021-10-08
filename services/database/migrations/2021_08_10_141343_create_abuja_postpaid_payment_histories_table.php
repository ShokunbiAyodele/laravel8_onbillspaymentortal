<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbujaPostpaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuja_postpaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('amount')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('receipt')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('creditToken')->nullable();
            $table->string('responseMessage')->nullable();
            $table->string('status')->nullable();
            $table->string('customerName')->nullable();
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
        Schema::dropIfExists('abuja_postpaid_payment_histories');
    }
}
