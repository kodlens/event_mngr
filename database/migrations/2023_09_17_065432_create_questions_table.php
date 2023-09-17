<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');


            $table->unsignedBigInteger('academic_year_id');
            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->integer('order_no')->default(0);

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('event_id')->on('events')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('question')->nullable();

            $table->string('input_type')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
