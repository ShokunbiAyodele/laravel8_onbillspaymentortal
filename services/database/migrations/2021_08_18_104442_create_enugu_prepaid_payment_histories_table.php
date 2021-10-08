<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnuguPrepaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enugu_prepaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('customerName')->nullable();
            $table->string('amount')->nullable();
            $table->string('token')->nullable();
            $table->string('status')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('ExchangeReference')->nullable();
            $table->string('responseMessage')->nullable();
            $table->string('invoiceNumber')->nullable();
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
        Schema::dropIfExists('enugu_prepaid_payment_histories');
    }
}