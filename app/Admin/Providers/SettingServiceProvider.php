<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\ISettingRepository','App\Admin\Repositories\SettingRepository');
	}

}