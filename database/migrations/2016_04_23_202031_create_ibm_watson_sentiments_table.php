<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIbmWatsonSentimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('IBMWatsonSentiments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->unique();
            $table->integer('symbol_id')->unsigned(); // IBMWatsonSentiments.symbol_id references Symbols.id

            $table->double('anger'); // Anger sentiment in percentage
            $table->double('disgust'); // Disgust sentiment in percentage
            $table->double('fear'); // Fear sentiment in percentage
            $table->double('joy'); // Joy sentiment in percentage
            $table->double('sadness'); // Sadness sentiment in percentage

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
        Schema::drop('IBMWatsonSentiments');
    }
}
