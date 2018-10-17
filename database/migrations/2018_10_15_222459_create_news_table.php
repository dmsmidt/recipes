<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('image_news')){
            Schema::create('news', function($table)
            {
                $table->increments('id');
                $table->string('name', 255)
                    ->unique();
                $table->integer('parent_id')->nullable()->index();
                $table->integer('lft')->nullable()->index();
                $table->integer('rgt')->nullable()->index();
                $table->integer('level')->nullable()->index();
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }

		if(!Schema::hasTable('image_news')){
            Schema::create('image_news', function($table)
            {
                $table->increments('id');
                $table->integer('news_id')->unsigned();
                $table->integer('image_id')->unsigned();
                $table->foreign('image_id')
                    ->references('id')->on('images')
                    ->onDelete('cascade');

            });
        }


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news');
	}
}