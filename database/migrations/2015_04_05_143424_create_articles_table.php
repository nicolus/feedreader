<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('articles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('full_content')->nullable();
            $table->string('guid');
            $table->dateTime('date');
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('feed_id')->references('id')->on('feeds');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('articles');
	}

}
