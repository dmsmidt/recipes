<?php namespace App\Admin\Creators;

use Recipe;

class RouteAdd {

    /**
     * adds the provider to th eprovider array in config/app.php
     * @param $name
     * @return bool
     */
    public function create($name){
        $recipe = Recipe::get($name);
        $name = $recipe->hasParent() ? $recipe->parent.'.'.$recipe->moduleName : $recipe->moduleName;
        $route = "  Route::resource('".$name."', '\\App\\Admin\\Http\\Controllers\\".studly_case(str_singular($recipe->moduleName))."Controller');";
        $path = base_path().'/routes/web.php';
        //get part of string
        $contents = file_get_contents($path);
        $start = strpos($contents,'//>>CMS')+7;
        $end = strpos($contents,'//<<CMS');
        $startIndex = min($start, $end);
        $length = abs($start - $end);
        $between = substr($contents, $startIndex, $length);
        //rewrite content
        $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $between).$route.PHP_EOL.'          ';
        $contents = substr_replace($contents, $str, $startIndex, $length);
        //modify and save file
        $file = fopen($path,'w+');
        if(fwrite($file,$contents)){
            return true;
        }
        return false;
    }

    public function remove($name){
        $recipe = Recipe::get($name);
        $name = $recipe->hasParent() ? $recipe->parent.'.'.$recipe->moduleName : $recipe->moduleName;
        $route = "  Route::resource('".$name."', '\\App\\Admin\\Http\\Controllers\\".studly_case(str_singular($recipe->moduleName))."Controller');";
        $path = base_path().'/routes/web.php';
        $contents = file_get_contents($path);
        $contents = str_replace($route, '', $contents);
        //modify and save file
        $file = fopen($path,'w+');
        if(fwrite($file,$contents)){
            return true;
        }
        return false;
    }
}