<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideshowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('slideshows', function($table)
	    {
		 $table->increments('id');
         $table->string('name', 255)
               ->unique();
         $table->boolean('active')->default(false);

		});

		Schema::create('image_slideshow', function($table)
	    {
            $table->increments('id');
            $table->integer('slideshow_id')->unsigned();
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
		Schema::drop('slideshows');
	}
}