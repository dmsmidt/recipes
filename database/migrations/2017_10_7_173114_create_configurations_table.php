<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('configurations', function($table)
	    {
		 $table->increments('id');
         $table->string('name', 50);
         $table->string('label', 50);
         $table->string('input_type', 50);
         $table->string('value_type', 50);
         $table->text('options')->nullable();
         $table->boolean('is_header')->nullable();
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
		Schema::drop('configurations');
	}
}