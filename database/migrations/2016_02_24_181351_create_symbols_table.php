<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Symbols', function (Blueprint $table) {

            $table->increments('id');
            $table->mediumText('exchange')->nullable();
            $table->char('symbol', 20)->unique();
            $table->mediumText('type')->nullable();
            $table->mediumText('cat')->nullable();
            $table->mediumText('expire_month')->nullable();
            $table->mediumText('expire_year')->nullable();
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
        Schema::table('Symbols', function (Blueprint $table) {

            Schema::drop('Symbols');

        });
    }
}
