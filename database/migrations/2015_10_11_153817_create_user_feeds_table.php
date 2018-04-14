<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('feed_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
    {
        Schema::drop('user_feeds');
    }
}
