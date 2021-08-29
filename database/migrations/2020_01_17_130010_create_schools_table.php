<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); //required for unique index
            $table->string('address_01')->nullable();
            $table->string('address_02')->nullable();
            $table->string('city')->nullable();
            $table->integer('geo_state_id')
                    ->foreign('geo_state_id')->references('id')->on('geo_states')
                    ->default(37); //NJ
            $table->string('postal_code'); //required for unique index
            $table->string('grades', 36)->comment('csv values ex. 9,10,11,12')->nullable();
            $table->timestamps();
            $table->unique(['name', 'postal_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
