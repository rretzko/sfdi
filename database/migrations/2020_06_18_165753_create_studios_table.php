<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->bigInteger('user_id')
                    ->foreign('user_id')->references('id')->on('users')
                    ->primary();
            $table->string('name')->default('My Studio'); 
            $table->string('address_01')->nullable();
            $table->string('address_02')->nullable();
            $table->string('city')->nullable();
            $table->integer('geo_state_id')
                    ->foreign('geo_state_id')->references('id')->on('geo_states')
                    ->default(37); //NJ
            $table->string('postal_code')->nullable(); //required for unique index
            $table->string('grades', 36)->comment('csv values ex. 9,10,11,12')->nullable();
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
        Schema::dropIfExists('studios');
    }
}
