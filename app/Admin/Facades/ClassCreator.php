<?php namespace App\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class ClassCreator extends Facade{

    protected static function getFacadeAccessor() { return 'class_creator'; }
} 