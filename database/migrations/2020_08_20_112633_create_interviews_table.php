<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->dateTime('interview_date');
            $table->set('format', [ 'online_testing','telephone', 'video_call', 'in_person',]);
            $table->string('interviewer', 250)->nullable();
            $table->string('notes', 500)->nullable();
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
        Schema::dropIfExists('interviews');
    }
}