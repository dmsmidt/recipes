<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('news', function($table)
	    {
		 $table->increments('id');
         $table->string('name', 255);

		});

		Schema::create('image_news', function($table)
	    {
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->integer('image_id')->unsigned();
                     $table->foreign('image_id')
               ->references('id')->on('images')
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
		Schema::drop('news');
	}
}