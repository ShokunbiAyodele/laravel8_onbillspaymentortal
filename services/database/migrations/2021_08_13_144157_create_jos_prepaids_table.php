<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJosPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jos_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('phone')->nullable();
            $table->string('customerAccountType')->nullable();
            $table->string('amount')->nullable();
            $table->string('company')->nullable();
            $table->string('requestId')->nullable();
            $table->string('billerRequestId')->nullable();
            $table->string('responseMessage')->nullable();
            $table->string('vendType')->nullable();
            $table->string('tariff')->nullable();
            $table->string('user_id')->nullable();
            $table->string('message')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('jos_prepaids');
    }
}
