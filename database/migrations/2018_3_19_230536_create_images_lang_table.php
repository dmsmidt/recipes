<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesLangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('images_lang', function($table)
	    {
		 $table->increments('id');
         $table->integer('image_id')
                  ->unsigned();
         $table->integer('language_id')
                  ->unsigned();
         $table->string('alt', 255)
                 ->nullable();
         $table->foreign('image_id')
               ->references('id')->on('images');
         $table->foreign('language_id')
               ->references('id')->on('languages');

		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images_lang');
	}
}