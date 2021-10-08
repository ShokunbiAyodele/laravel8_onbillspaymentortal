<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingAcceptedTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_accepted_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('user_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('meterNumber')->nullable();
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
        Schema::dropIfExists('pending_accepted_transactions');
    }
}
