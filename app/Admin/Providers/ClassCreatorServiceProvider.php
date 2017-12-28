<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ClassCreatorServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('class_creator', function()
        {
            return new \App\Admin\Creators\ClassCreator();
        });
    }

}
