<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class SlideshowServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\ISlideshowRepository','App\Admin\Repositories\SlideshowRepository');
	}

}