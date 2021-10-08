<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbadanPostpaidPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibadan_postpaid_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transactionNumber');
            $table->string('amount');
            $table->string('exchangeReference');
            $table->string('customerName');
            $table->string('user_id');
            $table->string('requestId');
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
        Schema::dropIfExists('ibadan_postpaid_payment_histories');
    }
}
