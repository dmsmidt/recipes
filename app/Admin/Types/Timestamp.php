<?php namespace App\Admin\Types;


class Timestamp extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        $column = $table->timestamp($this->_name);
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->timestamp(\''.$this->_name.'\')';
        $column .= ';'.PHP_EOL;
        return $column;
    }

    //Returns array with possible options
    public function getOptions(){
        return [
            "nullable",
            "default"
        ];
    }

} 