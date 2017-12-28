<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IMenuRepository','App\Admin\Repositories\MenuRepository');
	}

}