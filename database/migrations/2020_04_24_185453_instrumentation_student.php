<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstrumentationStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumentation_student', function (Blueprint $table) {
            $table->unsignedBigInteger('instrumentation_id');
            $table->unsignedBigInteger('student_user_id');
            $table->unsignedTinyInteger('order_by')->default(1);
            $table->primary(['instrumentation_id', 'student_user_id'],'instrument_student_primary');
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
        Schema::dropIfExists('instrumentation_student');
    }
}
