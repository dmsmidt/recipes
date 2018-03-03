<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('images', function($table)
	    {
		 $table->increments('id');
         $table->string('filename', 255);
         $table->integer('image_template_id')
                  ->unsigned();
         $table->boolean('active')->default(false);
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
		Schema::drop('images');
	}
}