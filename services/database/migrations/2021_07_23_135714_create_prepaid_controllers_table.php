<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrepaidControllersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prepaids', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->integer('user_id')->comment('user_id=userid')->nullable();
            $table->string('customerDistrict');
            $table->string('meterNumber');
            $table->string('billerRequestId');
            $table->string('message');
            $table->string('status');
            $table->string('transactionReference');
            $table->string('transactionDate');
            $table->string('amount');
            $table->string('address');
            $table->string('requestId');
            $table->string('code');
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
        Schema::dropIfExists('prepaid_controllers');
    }
}
