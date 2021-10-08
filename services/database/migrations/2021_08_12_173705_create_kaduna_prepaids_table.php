<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKadunaPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaduna_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('meterNumber');
            $table->string('phone');
            $table->string('tariff');
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
        Schema::dropIfExists('kaduna_prepaids');
    }
}
