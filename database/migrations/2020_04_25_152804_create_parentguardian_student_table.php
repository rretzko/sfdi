<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentguardianStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentguardian_student', function (Blueprint $table) {
            $table->unsignedBigInteger('parentguardian_user_id'); //user_id
            $table->unsignedBigInteger('student_user_id'); //user_id
            $table->unsignedBigInteger('parentguardiantype_id')
                    ->foreign('parentguardiantype_id')
                    ->references('id')->on('parentguardiantypes');
            $table->primary(['parentguardian_user_id', 'student_user_id', 'parentguardiantype_id'], 'pg_student');
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
        Schema::dropIfExists('parentguardian_student');
    }
}
