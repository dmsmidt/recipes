<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IUserRepository','App\Admin\Repositories\UserRepository');
	}

}