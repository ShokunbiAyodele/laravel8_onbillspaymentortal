<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnuguPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enugu_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('paymentPlan')->nullable();
            $table->string('phone')->nullable();
            $table->string('transactionDate')->nullable();
            $table->string('amount')->nullable();
            $table->string('requestId')->nullable();
            $table->string('billerRequestId')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('user_id')->nullable();
            $table->string('message')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('transactionReference')->nullable();
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
        Schema::dropIfExists('enugu_prepaids');
    }
}
