<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbujaPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuja_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('uniqueCode')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('transactionReference')->nullable();
            $table->string('transactionDate')->nullable();
            $table->string('customerReference')->nullable();
            $table->string('phone')->nullable();
            $table->string('amount')->nullable();
            $table->string('requestId')->nullable();
            $table->string('user_id')->nullable();
            $table->string('billerRequestId')->nullable();
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
        Schema::dropIfExists('abuja_prepaids');
    }
}
