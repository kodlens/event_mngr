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
            $table->id('event_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('event')->nullable();
            $table->text('event_description')->default('');
            $table->text('content')->default('');
            $table->dateTime('event_datetime')->nullable();
            $table->string('img_path')->default('');
            $table->string('event_type')->nullable();
            $table->tinyInteger('approval_status')->default(0);
            $table->tinyInteger('is_open')->default(0);
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
