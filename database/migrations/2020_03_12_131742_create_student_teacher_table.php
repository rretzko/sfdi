<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_teacher', function (Blueprint $table) {
            $table->unsignedBigInteger('student_user_id'); //user_id
            $table->unsignedBigInteger('teacher_user_id'); //user_id
            $table->integer('statustype_id')->default(4); //pending
            $table->primary(['student_user_id', 'teacher_user_id']);
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
        Schema::dropIfExists('student_teacher');
    }
}
