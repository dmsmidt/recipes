<?php namespace App\Admin\Creators;

/*
 * This class adds a new translation entry to a language array file in resources/lang.
 * It is called via the console command translation:add.
 * Translations added to these translation files are only used for the cms interface.
 * Each CMS module has its own translation array file
 * To mention, translations for the frontend are entered via cms form fields and saved in the database
 * Todo: If a module file doesn't exist, the console shows an error message that the file is missing.
 * Todo: When a file doesn't exist, it has to be created.
 * Todo: add functionality to CreateModel console command to create the language files if they don't already exist
 *
 */



class Language {

    protected $module;

    public function __construct($module){
        $this->module = $module;
    }

    /**
     * @param $lang
     * @param $default
     * @param $trans
     * @return bool
     */
    public function add($lang,$default,$trans){
        $path = 'resources/lang/'.$lang.'/'.$this->module.'.php';
        //$file = fopen($path,'a+');
        $contentrows = file($path);
        array_pop($contentrows);
        $contentrows[] = '  "'.$default.'"=>"'.$trans.'",'.PHP_EOL;
        $contentrows[] = '];';
        if(file_put_contents($path,implode('',$contentrows))){
            return true;
        }
        return false;
    }


} 