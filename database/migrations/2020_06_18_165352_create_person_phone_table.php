<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_phone', function (Blueprint $table) {
             $table->bigInteger('phone_id')
                    ->foreign('phone_id')->references('id')->on('phones');
            $table->bigInteger('user_id')
                    ->foreign('user_id')->references('id')->on('users');
            $table->set('type', ['home', 'mobile', 'work'])->default('mobile');
            $table->timestamps();
            $table->unique(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_phone');
    }
}
