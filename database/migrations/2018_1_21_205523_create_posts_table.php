<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('posts', function($table)
	    {
		 $table->increments('id');
         $table->string('title', 255);
         $table->text('text');
         $table->integer('parent_id')->nullable()->index();
         $table->integer('lft')->nullable()->index();
         $table->integer('rgt')->nullable()->index();
         $table->integer('level')->nullable()->index();
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
		Schema::drop('posts');
	}
}