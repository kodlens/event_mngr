<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_answers', function (Blueprint $table) {
            $table->id('evaluation_answer_id');

            $table->unsignedBigInteger('evaluation_id');
            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations')
                ->onDelete('cascade')->onUpdate('cascade');

            
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('question_id')->on('questions')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('rating')->default(0);

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
        Schema::dropIfExists('evaluation_answers');
    }
}
