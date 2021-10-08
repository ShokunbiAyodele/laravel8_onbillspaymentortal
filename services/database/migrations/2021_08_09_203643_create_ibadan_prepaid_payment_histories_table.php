<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbadanPrepaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibadan_prepaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber');
            $table->string('amount');
            $table->string('description');
            $table->string('standardTokenValue');
            $table->string('rate');
            $table->string('exchangeReference');
            $table->string('resetToken');
            $table->string('token');
            $table->string('status');
            $table->string('customerName');
            $table->string('requestId');
            $table->string('user_id');
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
        Schema::dropIfExists('ibadan_prepaid_payment_histories');
    }
}
