<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use View;


class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        view()->composer('admin', 'App\Admin\Http\ViewComposers\MainComposer');
        view()->composer('main.index', 'App\Admin\Http\ViewComposers\IndexComposer');
        view()->composer('main.form', 'App\Admin\Http\ViewComposers\FormComposer');
        //view()->composer('cms.includes.sortable', 'App\Admin\Http\ViewComposers\SortableComposer');
        //view()->composer('cms.includes.nestable', 'App\Admin\Http\ViewComposers\NestableComposer');
        view()->composer('main.settings', 'App\Admin\Http\ViewComposers\SettingsComposer');
        view()->composer('dialogs.dialog', 'App\Admin\Http\ViewComposers\DialogComposer');
        //view()->composer('cms.includes.crop', 'App\Admin\Http\ViewComposers\CropComposer');
	}

}
