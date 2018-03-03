<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ImageFormatServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IImageFormatRepository','App\Admin\Repositories\ImageFormatRepository');
	}

}