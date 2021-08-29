<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                    ->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
            $table->integer('old_id')->default(-1);
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('middle_name',255)->nullable();
            $table->unsignedBigInteger('pronoun_id')->default(1)
                    ->foreign('pronoun_id')->references('id')->on('pronouns')
                    ->onDelete('cascade');;
            $table->unsignedBigInteger('honorific_id')->default(1)
                    ->foreign('honorific_id')->references('id')->on('honorifics')
                    ->onDelete('cascade');;
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
