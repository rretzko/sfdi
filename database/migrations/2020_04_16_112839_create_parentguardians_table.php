<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentguardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentguardians', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                    ->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
            $table->unsignedTinyInteger('parentguardiantype_id')
                    ->foreign('parentguardiantype')
                    ->references('id')->on('parentguardiantypes');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['user_id', 'parentguardiantype_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parentguardians');
    }
}
