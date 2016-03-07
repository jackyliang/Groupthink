<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNameToSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Symbols', function (Blueprint $table) {
            // Adding a name to the Symbols table
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Symbols', function (Blueprint $table) {
            // Removing the name to the Symbols table
            $table->dropColumn('name');
        });
    }
}
