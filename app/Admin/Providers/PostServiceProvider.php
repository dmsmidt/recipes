<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\IPostRepository','App\Admin\Repositories\PostRepository');
	}

}