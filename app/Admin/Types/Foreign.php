<?php namespace App\Admin\Types;


class Foreign extends Type{

    public function __construct($name,$schema){
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        //
    }

    //Adding row to schema builder
    public function addSchema($table){
        //
    }

    //Returns array with possible options
    public function getOptions(){
        return [];
    }


} 