<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class MenuItemServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IMenuItemRepository','App\Admin\Repositories\MenuItemRepository');
	}

}