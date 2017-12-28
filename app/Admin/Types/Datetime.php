<?php namespace App\Admin\Types;


class Datetime extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        $column = $table->dateTime($this->_name);
        if($this->_nullable){$column->nullable();}
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->dateTime(\''.$this->_name.'\')';
        if($this->_nullable){$column .= PHP_EOL.'                  ->nullable()';}
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