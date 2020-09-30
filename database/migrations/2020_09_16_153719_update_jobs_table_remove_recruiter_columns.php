<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobsTableRemoveRecruiterColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // remove columns that will not be used
            $table->dropColumn('recruiter_name');
            $table->dropColumn('recruiter_email');
            $table->dropColumn('recruiter_phone');

            // rename some columns
            $table->renameColumn('application_date', 'date_applied');
            $table->renameColumn('job_title', 'title');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // opposite of dropping
            $table->string('recruiter_name')->nullable();
            $table->string('recruiter_email')->nullable();
            $table->string('recruiter_phone',9)->nullable();

            // un-rename some columns
            $table->renameColumn( 'date_applied', 'application_date');
            $table->renameColumn( 'title', 'job_title');
        });
    }
}
