<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class FormFieldServiceProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        \App::bind('form_field', function()
        {
            return new \App\Admin\Form\FormField();
        });
	}

}
