<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ImagesLangServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IImagesLangRepository','App\Admin\Repositories\ImagesLangRepository');
	}

}