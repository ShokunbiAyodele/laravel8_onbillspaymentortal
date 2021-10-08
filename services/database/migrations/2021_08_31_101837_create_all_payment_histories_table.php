<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('transactionStatus')->nullable();
            $table->string('status')->nullable();
            $table->string('returnMessage')->nullable();
            $table->string('amount')->nullable();
            $table->string('token')->nullable();
            $table->string('smartCard')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('accountId')->nullable();
            $table->string('responseMessage')->nullable();
            $table->string('tokenAmount')->nullable();
            $table->string('date')->nullable();
            $table->string('creditToken')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('standardTokenValue')->nullable();
            $table->string('customerName')->nullable();
            $table->string('requestId')->nullable();
            $table->string('user_id')->nullable();
            $table->string('debtAmount')->nullable();
            $table->string('standardTokenAmount')->nullable();
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
        Schema::dropIfExists('all_payment_histories');
    }
}
