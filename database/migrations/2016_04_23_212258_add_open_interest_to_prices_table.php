<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpenInterestToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Prices', function (Blueprint $table) {
            // Add open_interest the Prices table
            $table->integer('open_interest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Prices', function (Blueprint $table) {
            // Removing open_interest from Prices table
            $table->dropColumn('open_interest');
        });
    }
}
