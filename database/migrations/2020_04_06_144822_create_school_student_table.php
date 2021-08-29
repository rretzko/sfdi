<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_student', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_user_id');
            $table->unsignedInteger('statustype_id')->default(4); //pending
            $table->primary(['school_id', 'student_user_id']);
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
        Schema::dropIfExists('school_student');
    }
}
