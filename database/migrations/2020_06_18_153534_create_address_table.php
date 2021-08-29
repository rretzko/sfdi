<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigInteger('user_id')->primary();
            $table->string('address_01')->nullable();
            $table->string('address_02')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('geo_state_id')
                    ->foreign('geo_state_id')->references('id')->on('geo_states');
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
