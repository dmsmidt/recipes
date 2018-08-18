<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class MenuItemsLangServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IMenuItemsLangRepository','App\Admin\Repositories\MenuItemsLangRepository');
	}

}