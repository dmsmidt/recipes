<?php namespace App\Admin\Creators;


class ServiceProvider {

    /**
     * adds the provider to th eprovider array in config/app.php
     * @param $name
     * @return bool
     */
    public function create($name){
        $provider = studly_case(str_singular($name));
        $classpath = 'App\\Admin\\Providers\\'.$provider.'ServiceProvider::class,';
        $path = base_path().'/config/app.php';
        //get part of string
        $contents = file_get_contents($path);
        $start = strpos($contents,'//>>CMS')+7;
        $end = strpos($contents,'//<<CMS');
        $startIndex = min($start, $end);
        $length = abs($start - $end);
        $between = substr($contents, $startIndex, $length);
        //rewrite content
        $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $between).$classpath.PHP_EOL.'        ';
        $contents = substr_replace($contents, $str, $startIndex, $length);
        //modify and save file
        $file = fopen($path,'w+');
        if(fwrite($file,$contents)){
            return true;
        }
        return false;
    }

    public function remove($name){
        $provider = studly_case(str_singular($name));
        $classpath = 'App\\Admin\\Providers\\'.$provider.'ServiceProvider::class,';
        $path = base_path().'/config/app.php';
        $contents = file_get_contents($path);
        $contents = str_replace($classpath, '', $contents);
        $file = fopen($path,'w+');
        if(fwrite($file,$contents)){
            return true;
        }
        return false;
    }
}