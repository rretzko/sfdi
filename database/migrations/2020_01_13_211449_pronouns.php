<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pronouns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pronouns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descr');
            $table->string('intensive');
            $table->string('personal');
            $table->string('possessive');
            $table->string('object');
            $table->integer('order_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('pronouns');
    }
}
