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
        $constrain = '         $table->foreign(\''.$this->_name.'_id\')'.PHP_EOL;
        $constrain .= '               ->references(\'id\')->on(\''.$this->_name.'\')'.PHP_EOL;
        $constrain .= '               ->onDelete(\'cascade\')';
        $constrain .= ';'.PHP_EOL;
        return $constrain;    }

    //Returns array with possible options
    public function getOptions(){
        return [];
    }


} 