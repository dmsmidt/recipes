<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'App\Admin\Repositories\Contracts\ILanguageRepository','App\Admin\Repositories\LanguageRepository');
	}

}