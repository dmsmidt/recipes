<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigurationServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IConfigurationRepository','App\Admin\Repositories\ConfigurationRepository');
	}

}