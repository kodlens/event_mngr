<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_files', function (Blueprint $table) {
            $table->id('event_file_id');

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('event_id')->on('events')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->string('event_filename', 100)->nullable();
            $table->string('event_file_path')->nullable();

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
        Schema::dropIfExists('event_files');
    }
}
