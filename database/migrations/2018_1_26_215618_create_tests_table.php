<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('tests', function($table)
	    {
		 $table->increments('id');
         $table->string('name', 50);
         $table->tinyInteger('levels');
         $table->integer('parent_id')->nullable()->index();
         $table->integer('lft')->nullable()->index();
         $table->integer('rgt')->nullable()->index();
         $table->integer('level')->nullable()->index();
         $table->boolean('active')->default(false);
         $table->boolean('protect')->default(false);

		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tests');
	}
}