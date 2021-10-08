<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJosPostpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jos_postpaids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('meterNumber');
            $table->string('phone');
            $table->string('amount');
            $table->string('requestId');
            $table->string('billerRequestId');
            $table->string('responseMessage');
            $table->string('vendType');
            $table->string('tariff');
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
        Schema::dropIfExists('jos_postpaids');
    }
}
