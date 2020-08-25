<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title', 50);
            $table->string('company', 50);
            $table->boolean('active')->default(true);
            $table->string('location', 50);
            $table->decimal('salary')->nullable();
            $table->dateTime('closing_date')->nullable();
            $table->dateTime('application_date')->nullable();
            $table->text('description')->nullable();
            $table->string('recruiter_name')->nullable();
            $table->string('recruiter_email')->nullable();
            $table->string('recruiter_phone',9)->nullable();
            $table->enum('stage', [1,2,3,4]);
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
        Schema::dropIfExists('jobs');
    }
}
