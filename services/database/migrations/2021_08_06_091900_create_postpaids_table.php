<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postpaids', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->integer('user_id')->comment('user_id=userid')->nullable();
            $table->string('businessUnit')->nullable();
            $table->string('customerReference')->nullable();
            $table->string('meterNumber')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('transactionReference')->nullable();
            $table->string('transactionDate')->nullable();
            $table->string('amount')->nullable();
            $table->string('requestId')->nullable();
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
        Schema::dropIfExists('postpaids');
    }
}
