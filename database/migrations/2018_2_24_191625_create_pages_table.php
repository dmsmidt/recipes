<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('pages', function($table)
	    {
		 $table->increments('id');
         $table->text('html');
         $table->string('name', 255)
               ->unique();
         $table->boolean('active')->default(false);
         $table->boolean('protect')->default(false);
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
		Schema::drop('pages');
	}
}