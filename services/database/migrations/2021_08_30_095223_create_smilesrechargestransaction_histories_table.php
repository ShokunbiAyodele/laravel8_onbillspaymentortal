<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmilesrechargestransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smilesrechargestransaction_histories', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('transactionNumber')->nullable();
            $table->string('requestId')->nullable();
            $table->string('customerName')->nullable();
            $table->string('email')->nullable();
            $table->string('accountId')->nullable();
            $table->string('amount')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('smilesrechargestransaction_histories');
    }
}
