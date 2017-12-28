<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('menu_items', function($table)
	    {
		 $table->increments('id');
         $table->integer('menu_id')
                  ->unsigned();
         $table->string('name', 50);
         $table->string('icon', 50)
                 ->nullable();
         $table->string('url', 255);
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
		Schema::drop('menu_items');
	}
}