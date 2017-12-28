<?php

namespace App\Admin\Providers;

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
        \App::bind('admin_request', function()
        {
            return new \App\Admin\Http\Requests\AdminRequest();
        });
    }
}
