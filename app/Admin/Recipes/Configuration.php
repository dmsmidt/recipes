<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Configuration extends Recipe{

    use Ingredients;

    public $moduleName = 'configurations';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "label" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Label",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "input_type" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Input type",
                            "input" => "select",
                            "options" => [
                                [
                                    "text" => "",
                                    "value" => ""
                                ],
                                [
                                    "text" => "Text",
                                    "value" => "text"
                                ],
                                [
                                    "text" => "TextArea",
                                    "value" => "textarea"
                                ],
                                [
                                    "text" => "E-mail",
                                    "value" => "email"
                                ],
                                [
                                    "text" => "Checkbox",
                                    "value" => "checkbox"
                                ],
                                [
                                    "text" => "Radio",
                                    "value" => "radio"
                                ],
                                [
                                    "text" => "Select",
                                    "value" => "select"
                                ],            ]
                        ],
            "value_type" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Value type",
                            "input" => "select",
                            "options" => [
                                [
                                    "text" => "",
                                    "value" => ""
                                ],
                                [
                                    "text" => "String",
                                    "value" => "varchar"
                                ],
                                [
                                    "text" => "Text",
                                    "value" => "text"
                                ],
                                [
                                    "text" => "Boolean",
                                    "value" => "boolean"
                                ],
                                [
                                    "text" => "Integer",
                                    "value" => "integer"
                                ],
                                [
                                    "text" => "Float",
                                    "value" => "float_number"
                                ],
                                [
                                    "text" => "Datetime",
                                    "value" => "datetime"
                                ],
                                [
                                    "text" => "Timestamp",
                                    "value" => "timestamp"
                                ],            ]
                        ],
            "options" => [
                            "type" => "text",
                            "nullable" => 1,
                            "label" => "Options(comma separated)",
                            "input" => "text",
                        ],
            "is_header" => [
                            "type" => "boolean",
                            "default" => "0",
                            "nullable" => 1,
                            "label" => "Show as header",
                            "input" => "checkbox",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name","label","is_header"];
    public $fillable = ["name","label","input_type","value_type","options","is_header"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = true;
    public $nestable = false;
    public $timestamps = false;
    public $has_one = [
            [
                "table" => "settings",
                "inverse" => true,
                "cascade" => false,
                "with" => false
            ],
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}