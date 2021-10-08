<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGotvSuscriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gotv_suscription_details', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('smartCard')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('amount')->nullable();
            $table->string('invoicePeriod')->nullable();
            $table->string('customerNumber')->nullable();
            $table->string('productsCode')->nullable();
            $table->string('dueDate')->nullable();
            $table->string('requestId')->nullable();
            $table->string('user_id')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('billerRquestId')->nullable();
            $table->string('transactionReference')->nullable();
            $table->string('transactionDate')->nullable();
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
        Schema::dropIfExists('gotv_suscription_details');
    }
}
