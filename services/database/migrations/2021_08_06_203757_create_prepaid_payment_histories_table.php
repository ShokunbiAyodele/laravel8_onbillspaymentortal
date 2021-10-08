<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrepaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prepaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber')->nullable();
            $table->string('bsstTokenValue')->nullable();
            $table->string('fixedTariff')->nullable();
            $table->string('standardTokenValue')->nullable();
            $table->string('bsstTokenDescription')->nullable();
            $table->string('fixedAmount')->nullable();
            $table->string('utilityAddress')->nullable();
            $table->string('utilityName')->nullable();
            $table->string('debtAmount')->nullable();
            $table->string('clientId')->nullable();
            $table->string('bsstTokenDate')->nullable();
            $table->string('utilityTaxReference')->nullable();
            $table->string('exchangeReference')->nullable();
            $table->string('status')->nullable();
            $table->string('standardTokenAmount')->nullable();
            $table->string('customerName')->nullable();
            $table->string('requestId')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('prepaid_payment_histories');
    }
}
