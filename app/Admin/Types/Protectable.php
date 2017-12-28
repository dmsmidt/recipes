<?php namespace App\Admin\Types;


class Protectable extends Type{

    public function __construct($name = '',$schema = []){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        return $table->boolean('protect')->default(false);
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->boolean(\'protect\')->default(false)';
        $column .= ';'.PHP_EOL;
        return $column;
    }
}