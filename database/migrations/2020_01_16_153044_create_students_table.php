<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary()
                    ->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
            $table->integer('class_of');
            $table->integer('height')->default(30);
            $table->datetime('birthday')->nullable();
            $table->integer('shirt_size')->default(1)
                    ->foreign('shirt_size')->references('id')->on('shirt_sizes')
                    ->onDelete('cascade'); //Medium
            $table->integer('updated_by')->default(-1);
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
