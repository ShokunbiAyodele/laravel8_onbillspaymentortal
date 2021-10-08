<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGotvTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gotv_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->string('smartCard')->nullable();
            $table->string('customerName')->nullable();
            $table->string('amount')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('status')->nullable();
            $table->string('ExchangeReference')->nullable();
            $table->string('customerCareReferenceId')->nullable();
            $table->string('auditReferenceNumber')->nullable();
            $table->string('user_id')->nullable();
            $table->string('requestId')->nullable();
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
        Schema::dropIfExists('gotv_transaction_histories');
    }
}
