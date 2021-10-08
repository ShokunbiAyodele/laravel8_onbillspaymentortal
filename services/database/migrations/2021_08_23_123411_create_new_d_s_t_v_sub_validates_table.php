<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewDSTVSubValidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_d_s_t_v_sub_validates', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('availablePricingOptions');
            $table->string('name');
            $table->string('price');
            $table->string('date');
            $table->string('description');
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
        Schema::dropIfExists('new_d_s_t_v_sub_validates');
    }
}
