<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Prices', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->date('date');
            $table->integer('symbol_id')->unsigned(); // Prices.symbol_id references Symbols.id
            $table->float('open')->nullable();
            $table->float('high')->nullable();
            $table->float('low')->nullable();
            $table->float('last')->nullable();
            $table->float('settle')->nullable();
            $table->integer('volume')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('symbol_id')
                ->references('id')->on('Symbols')
                ->onDelete('cascade');

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
            Schema::drop('Prices');
        });
    }
}
