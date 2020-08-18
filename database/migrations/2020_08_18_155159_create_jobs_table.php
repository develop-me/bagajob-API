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
            $table->set('status', ['active', 'archived']);
            $table->string('location', 50);
            $table->decimal('salary')->nullable();
            $table->date('closing_date')->nullable();
            $table->date('application_date')->nullable();
            $table->text('description')->nullable();
            $table->string('recruiter_name')->nullable();
            $table->string('recruiter_email')->nullable();
            $table->integer('recruiter_phone')->nullable();
            $table->enum('stage', [1,2,3]);
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
