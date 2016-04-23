<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStanfordNlpSentimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StanfordNLPSentiments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->unique();
            $table->integer('symbol_id')->unsigned(); // StanfordNLPSentiments.symbol_id references Symbols.id
            $table->integer('polarity');
            $table->timestamps();

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
        Schema::drop('StanfordNLPSentiments');
    }
}
