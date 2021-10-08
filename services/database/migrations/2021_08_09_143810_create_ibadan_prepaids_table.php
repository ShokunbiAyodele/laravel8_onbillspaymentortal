<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbadanPrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibadan_prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('meterNumber')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('otherName')->nullable();
            $table->string('customerReference')->nullable();
            $table->string('email')->nullable(); 
            $table->string('minimumAmount')->nullable(); 
            $table->string('transactionDate')->nullable(); 
            $table->string('message')->nullable(); 
            $table->string('thirdPartyCode')->nullable();
            $table->string('transactionReference')->nullable();
            $table->string('billerRequestId')->nullable();
            $table->string('outstandingAmount')->nullable(); 
            $table->string('customerType')->nullable();
            $table->string('requestId')->nullable();  
            $table->string('user_id')->nullable(); 
            $table->string('status')->nullable(); 
            $table->string('amount')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('ibadan_prepaids');
    }
}
