<?php namespace App\Admin\Types;


class Increments extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        $column = $table->increments($this->_name);
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = ' $table->increments(\''.$this->_name.'\');'.PHP_EOL;
        return $column;
    }

    //Returns array with possible options
    public function getOptions(){
        return [];
    }

} 