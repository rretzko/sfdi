<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentguardiantypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentguardiantypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descr',24);
            $table->unsignedTinyInteger('pronoun_id')->default(1)
                    ->foreign('pronoun_id')->references('id')->on('pronouns');;
            $table->unsignedTinyInteger('order_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parenttypes', function (Blueprint $table) {
            //
        });
    }
}
