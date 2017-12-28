<?php namespace App\Admin\Types;


class Activatable extends Type{

    public function __construct($name = '', $schema = []){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        return $table->boolean('active')->default(false);
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->boolean(\'active\')->default(false)';
        $column .= ';'.PHP_EOL;
        return $column;
    }
}