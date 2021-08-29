<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditiondetails', function (Blueprint $table) {
            $table->unsignedBigInteger('auditionnumber')->primary();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('eventversion_id');
            $table->string('programname');
            $table->string('voicings');
            $table->smallInteger('statustype_id')->default(4); //pending
            $table->boolean('signatures')->default(0);
            $table->timestamps();
            $table->unique(['user_id', 'eventversion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditiondetails');
    }
}
