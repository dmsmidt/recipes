<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\INewsRepository','App\Admin\Repositories\NewsRepository');
	}

}