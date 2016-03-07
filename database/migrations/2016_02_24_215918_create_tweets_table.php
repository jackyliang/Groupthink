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
            $table->string('symbol', 10);
            $table->timestamp('timestamp')->nullable();
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
        Schema::table('Tweets', function (Blueprint $table) {
            //
            Schema::drop('Tweets');
        });
    }
}
