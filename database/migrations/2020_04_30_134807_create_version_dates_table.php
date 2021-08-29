<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventversion_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('eventversion_id')->index()
                    ->foreign('eventversion_id')->references('id')->on('eventversions');
            $table->bigInteger('date_type_id')
                    ->foreign('date_type_id')->references('id')->on('date_types');
            $table->dateTime('dt');
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
        Schema::dropIfExists('version_dates');
    }
}
