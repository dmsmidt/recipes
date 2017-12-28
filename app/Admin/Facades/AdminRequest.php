<?php namespace App\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminRequest extends Facade{

    protected static function getFacadeAccessor() { return 'admin_request'; }

} 