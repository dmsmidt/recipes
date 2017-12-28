<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IDashboardRepository','App\Admin\Repositories\DashboardRepository');
	}

}