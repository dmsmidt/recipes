<?php namespace App\Admin\Types;


class Nestable extends Type{

    public function __construct($name = '',$schema = []){
        parent::__construct($name,$schema);
    }

    //Adding row to schema builder
    public function addSchema($table){
        $column = '         $table->integer(\'parent_id\')->nullable()->index();'.PHP_EOL;
        $column .= '         $table->integer(\'lft\')->nullable()->index();'.PHP_EOL;
        $column .= '         $table->integer(\'rgt\')->nullable()->index();'.PHP_EOL;
        $column .= '         $table->integer(\'level\')->nullable()->index();'.PHP_EOL;
        return $column;
    }


}