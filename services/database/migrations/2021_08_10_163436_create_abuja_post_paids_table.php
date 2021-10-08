<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbujaPostPaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuja_post_paids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uniqueCode');
            $table->string('customerReference');
            $table->string('phone');
            $table->string('amount');
            $table->string('requestId');
            $table->string('user_id');
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
        Schema::dropIfExists('abuja_post_paids');
    }
}
