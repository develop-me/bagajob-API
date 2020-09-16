<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateColumnNameForInterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interviews', function (Blueprint $table) {
            // rename column
            $table->renameColumn('interview_date', 'date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interviews', function (Blueprint $table) {
            // opposite of rename column
            $table->renameColumn('date', 'interview_date');
        });
    }
}
