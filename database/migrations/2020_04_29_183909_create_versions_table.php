<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')
                    ->foreign('event_id')->references('id')->on('events');
            $table->string('name', 60);
            $table->string('short_name', 30);
            $table->smallInteger('senior_class_of')->default(1970);
            $table->set('status', ['active', 'closed', 'sandbox'])->default('closed');
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
        Schema::dropIfExists('eventversions');
    }
}
