<?php namespace App\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Recipe extends Facade{

    protected static function getFacadeAccessor() { return 'recipe'; }

} 