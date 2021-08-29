<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_teacher', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('teacher_user_id');
            $table->integer('start_year')->default(1960);
            $table->integer('end_year')->nullable();
            $table->unsignedInteger('statustype_id',)->default(1); //active
            $table->unique(['school_id', 'teacher_user_id', 'start_year']);
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
        Schema::dropIfExists('school_teacher');
    }
}
