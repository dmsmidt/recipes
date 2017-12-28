<?php namespace App\Admin\Types;


class Enum extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        $options = [];
        foreach($this->_options as $option){
            $options[] = $option;
        }
        $column = $table->enum($this->_name, $options)->default($this->_default);
        if($this->_nullable){$column->nullable();}
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        $options = [];
        foreach($this->_options as $option){
            $options[] = $option;
        }
        $column = '         $table->enum(\''.$this->_name.'\', '.$options.')->default('.$this->_default.')';
        if($this->_nullable){$column .= PHP_EOL.'                  ->nullable()';}
        $column .= ';'.PHP_EOL;
        return $column;
    }

    //Returns array with possible options
    public function getOptions(){
        return [
            "nullable",
            "default",
            "options"
        ];
    }


} 