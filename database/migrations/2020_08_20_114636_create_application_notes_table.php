<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_notes', function (Blueprint $table) {

            //columns for the note data inputs
            $table->id();
            $table->string('note_name', 50);
            $table->date('date');
            $table->string('body', 500);
            $table->timestamps();

            //create a job id column
            $table->foreignId('job_id')->unsigned();

            //assign the id from jobs table to the job_id column
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_notes');
    }
}
