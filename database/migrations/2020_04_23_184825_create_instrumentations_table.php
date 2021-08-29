<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descr', 36)->unique();
            $table->string('abbr', 12)->unique();
            $table->set('branch', ['choral', 'instrumental'])->index();
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
        Schema::dropIfExists('instrumentations');
    }
}
