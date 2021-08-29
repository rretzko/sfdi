<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_person', function (Blueprint $table) {
            $table->bigInteger('email_id')
                    ->foreign('email_id')->references('id')->on('emails');
            $table->bigInteger('user_id')
                    ->foreign('user_id')->references('id')->on('users');
            $table->set('type', ['alternate', 'primary'])->default('primary');
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
        Schema::dropIfExists('email_person');
    }
}
