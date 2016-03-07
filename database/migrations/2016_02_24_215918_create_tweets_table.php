<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tweets', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('message_id')->nullable()->unique();
            $table->string('username', 45)->nullable();
            $table->text('body');
            $table->integer('symbol_id')->unsigned(); // Tweets.symbol_id references Symbols.id
            $table->timestamp('timestamp')->nullable();
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
        Schema::table('Tweets', function (Blueprint $table) {
            //
            Schema::drop('Tweets');
        });
    }
}
