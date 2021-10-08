<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkejaPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikeja_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('meterNumber');
            $table->string('phone');
            $table->string('customerDtNumber');
            $table->string('customerAccountType');
            $table->string('amount');
            $table->string('requestId');
            $table->string('billerRequestId');
            $table->string('user_id');
            $table->string('message');
            $table->string('email');
            $table->string('status');
            $table->string('transactionReference');
            $table->string('transactionDate');
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
        Schema::dropIfExists('ikeja_prepaids');
    }
}
