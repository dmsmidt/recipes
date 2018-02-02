<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('test_items', function($table)
	    {
		 $table->increments('id');
         $table->integer('test_id')
                  ->unsigned();
         $table->string('name', 50);
         $table->string('icon', 50)
                 ->nullable();
         $table->string('url', 255);
         $table->foreign('roles_id')
               ->references('id')->on('roles')
               ->onDelete('cascade');
         $table->integer('parent_id')->nullable()->index();
         $table->integer('lft')->nullable()->index();
         $table->integer('rgt')->nullable()->index();
         $table->integer('level')->nullable()->index();
         $table->boolean('active')->default(false);
         $table->boolean('protect')->default(false);

		});

		Schema::create('roles_test_items', function($table)
	    {
            $table->increments('id');
            $table->integer('test_item_id')->unsigned();
            $table->integer('role_id')->unsigned();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test_items');
	}
}