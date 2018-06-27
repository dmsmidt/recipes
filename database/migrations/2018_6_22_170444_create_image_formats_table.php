<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageFormatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('image_formats', function($table)
	    {
		 $table->increments('id');
         $table->string('image_template', 255);
         $table->string('name', 100);
         $table->double('x', 15, 10)
                  ->nullable();
         $table->double('y', 15, 10)
                  ->nullable();
         $table->double('width', 15, 10);
         $table->double('height', 15, 10);
         $table->string('scaling', 10)
               ->default('fit')
                 ->nullable();
         $table->integer('image_id')
                  ->nullable()
                  ->unsigned();
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
		Schema::drop('image_formats');
	}
}