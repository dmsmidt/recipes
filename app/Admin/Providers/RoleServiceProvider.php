<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IRoleRepository','App\Admin\Repositories\RoleRepository');
	}

}