<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmilesRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smiles_recharges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('accountId')->nullable();
            $table->string('email')->nullable();
            $table->string('mobileNumber')->nullable();
            $table->string('amount')->nullable();
            $table->string('date_created')->nullable();
            $table->string('requestId')->nullable();
            $table->string('billerRequestId')->nullable();
            $table->string('user_id')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('transactionDate')->nullable();
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
        Schema::dropIfExists('smiles_recharges');
    }
}
