<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RecipeServiceProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        \App::bind('recipe', function()
        {
            return new \App\Admin\Recipes\Recipe();
        });
	}

}
