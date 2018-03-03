<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ImageTemplateServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IImageTemplateRepository','App\Admin\Repositories\ImageTemplateRepository');
	}

}