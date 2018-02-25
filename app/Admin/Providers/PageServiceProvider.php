<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IPageRepository','App\Admin\Repositories\PageRepository');
	}

}