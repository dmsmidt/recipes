<?php namespace App\Admin\Types;


class Longtext extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        $column = $table->longText($this->_name);
        if($this->_default){$column->default($this->_default);}
        if($this->_nullable){$column->nullable();}
        if($this->_unique){$column->unique();}
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->longText(\''.$this->_name.'\')';
        if($this->_default){$column .= PHP_EOL.'                  ->default(\''.$this->_default.'\')';}
        if($this->_nullable){$column .= PHP_EOL.'                  ->nullable()';}
        if($this->_unique){$column .= PHP_EOL.'                  ->unique()';}
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