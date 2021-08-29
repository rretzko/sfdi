<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sent_to_user_id')
                    ->foreign('sent_to_user_id')->references('id')->on('users');
            $table->bigInteger('sent_by_user_id')
                    ->foreign('sent_by_user_id')->references('id')->on('users');
            $table->set('sent_to', ['alternate', 'primary'])->default('primary');
            $table->string('header', 24);
            $table->string('excerpt');
            $table->text('missive');
            $table->integer('statustype_id')->default(1);
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
        Schema::dropIfExists('missives');
    }
}
