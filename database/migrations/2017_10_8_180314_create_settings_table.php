<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('settings', function($table)
	    {
		 $table->increments('id');
         $table->integer('configuration_id')
                  ->unsigned();
         $table->string('string', 255)
                 ->nullable();
$table->text('text')
->nullable();
         $table->boolean('boolean')
                  ->nullable();
         $table->integer('integer')
                  ->nullable();
         $table->float('float')
                  ->nullable();
         $table->dateTime('datetime')
                  ->nullable();
         $table->timestamp('timestamp')
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
		Schema::drop('settings');
	}
}