<?php namespace App\Admin\Types;


class Varchar extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        if($this->_length)
        {
            $column = $table->string($this->_name, $this->_length);
        }else{
            $column = $table->string($this->_name);
        }
        if($this->_default){$column->default($this->_default);}
        if($this->_nullable){$column->nullable();}
        if($this->_unique){$column->unique();}
        return $column;
    }

    //Adding row to schema builder
    public function addSchema($table){
        if($this->_length)
        {
            $column = '         $table->string(\''.$this->_name.'\', '.$this->_length.')';
        }else{
            $column = '         $table->string(\''.$this->_name.'\')';
        }
            if(is_int($this->_default)){$column .= PHP_EOL.'                  ->default('.$this->_default.')';}
            if(is_string($this->_default)){$column .= PHP_EOL.'               ->default(\''.$this->_default.'\')';}
            if($this->_nullable){$column .= PHP_EOL.'                 ->nullable()';}
            if($this->_unique){$column .= PHP_EOL.'               ->unique()';}
        $column .= ';'.PHP_EOL;
        return $column;
    }

    //Returns array with possible options
    public function getOptions(){
        return [
            "unique",
            "nullable",
            "default",
            "length"
        ];
    }


} 