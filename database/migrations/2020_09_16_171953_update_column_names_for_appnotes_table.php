<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnNamesForAppnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_notes', function (Blueprint $table) {
            // rename body to data
            $table->renameColumn('body', 'data');

            // drop note_name
            $table->dropColumn('note_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_notes', function (Blueprint $table) {
            // undo changes
            $table->renameColumn('data', 'body');
            $table->string('note_name', 50);
        });
    }
}
