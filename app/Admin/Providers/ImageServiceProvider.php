<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IImageRepository','App\Admin\Repositories\ImageRepository');
	}

}