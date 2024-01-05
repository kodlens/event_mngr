<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_recipients', function (Blueprint $table) {
            $table->id('custom_recipient_id');

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('event_id')->on('events')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('email', 50)->nullable();
                
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
        Schema::dropIfExists('custom_recipients');
    }
}
