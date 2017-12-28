<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsLangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('menu_items_lang', function($table)
	    {
		 $table->increments('id');
         $table->integer('menu_item_id')
                  ->unsigned();
         $table->integer('language_id')
                  ->unsigned();
         $table->string('text', 100)
                 ->nullable();

		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_items_lang');
	}
}