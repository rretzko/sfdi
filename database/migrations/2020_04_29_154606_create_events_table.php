<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_name', 60);
            $table->string('short_name', 30);
            $table->unsignedSmallInteger('organization_id')
                    ->foreign('organization_id')->references('id')->on('organizations');
            $table->unsignedTinyInteger('eventinstrumentation_id') 
                    ->foreign('eventinstrumentation_id')->references('id')->on('eventinstrumentations');
            $table->set('frequency', ['annual'])->default('annual'); //allow for future growth
            $table->string('grades', 24)->default('9,10,11,12')->comment('csv string ex. 9,10,11');
            $table->set('status', ['active', 'inactive', 'sandbox']);
            $table->unsignedSmallInteger('first_event');
            $table->string('logo_file', 60);
            $table->string('logo_file_alt', 60);
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
        Schema::dropIfExists('events');
    }
}
