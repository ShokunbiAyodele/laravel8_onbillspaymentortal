<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbadanPostpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibadan_postpaids', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('otherName')->nullable();
            $table->string('customerReference')->nullable();
            $table->string('email')->nullable(); 
            $table->string('transactionDate')->nullable(); 
            $table->string('message')->nullable(); 
            $table->string('thirdPartyCode')->nullable();
            $table->string('billerRequestId')->nullable();
            $table->string('transactionReference')->nullable();
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
        Schema::dropIfExists('ibadan_postpaids');
    }
}
