<?php namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminRequestServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Admin\Http\Requests\IAdminRequest','App\Admin\Http\Requests\AdminRequest');
    }
}
