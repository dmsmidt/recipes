<?php namespace App\Admin\Types;


class Timestamps extends Type{

    public function __construct($name = '',$schema = []){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        return $table->timestamps();
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->timestamps()';
        $column .= ';'.PHP_EOL;
        return $column;
    }


}