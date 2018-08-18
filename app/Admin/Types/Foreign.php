<?php namespace App\Admin\Types;


class Foreign extends Type{

    public function __construct($name,$schema = null){
        $this->_name = $name;
        parent::__construct($name,$schema);
    }

    //Adding column to database table
    public function addColumn($table){
        //
    }

    //Adding row to schema builder
    public function addSchema($rel){
        $constrain = '         $table->foreign(\''.$this->_name.'_id\')'.PHP_EOL;
        $constrain .= '               ->references(\'id\')->on(\''.$rel['table'].'\')';
        $constrain .= $rel['cascade'] ? PHP_EOL.'               ->onDelete(\'cascade\');' : ';';
        $constrain .= PHP_EOL;
        return $constrain;    }

    //Returns array with possible options
    public function getOptions(){
        return [
            'relation'
        ];
    }


} 