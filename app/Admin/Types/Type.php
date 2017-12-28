<?php namespace App\Admin\Types;


class Type {

    protected $_name;
    protected $_length;
    protected $_decimals;
    protected $_options;
    protected $_unsigned;
    protected $_nullable;
    protected $_key;
    protected $_default;
    protected $_unique;
    protected $_has_one;
    protected $_has_many;
    protected $_many_many;

    /**
     * @param $schema
     * @param $type 'db_model' or 'db_sql'
     */
    public function __construct($name,$schema){
        if(count($schema)){
            $this->_name = $name;
            $this->_length = isset($schema['length']) ? $schema['length'] : null;
            $this->_decimals = isset($schema['decimals']) ? $schema['decimals'] : null;
            $this->_options = isset($schema['options']) ? $schema['options'] : null;
            $this->_unsigned = isset($schema['unsigned']) ? $schema['unsigned'] : null;
            $this->_nullable = isset($schema['nullable']) ? $schema['nullable'] : null;
            $this->_default = isset($schema['default']) ? $schema['default'] : null;
            $this->_unique = isset($schema['unique']) ? $schema['unique'] : null;
            $this->_has_one = isset($schema['has_one']) ? $schema['has_one'] : null;
            $this->_has_many = isset($schema['has_many']) ? $schema['has_many'] : null;
            $this->_many_many = isset($schema['many_many']) ? $schema['many_many'] : null;
        }
    }
}