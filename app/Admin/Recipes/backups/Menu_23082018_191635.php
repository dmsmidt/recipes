<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Menu extends Recipe{

    use Ingredients;

    public $moduleName = 'menus';
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
            "levels" => [
                            "type" => "tinyinteger",
                            "label" => "Sub levels",
                            "input" => "select",
                            "options" => [
                                [
                                    "text" => "1",
                                    "value" => "1"
                                ],
                                [
                                    "text" => "2",
                                    "value" => "2"
                                ],
                                [
                                    "text" => "3",
                                    "value" => "3"
                                ],
                                [
                                    "text" => "4",
                                    "value" => "4"
                                ],            ]
                        ],
            "menu_items" => [
                            "type" => "foreign",
                            "label" => "Menu items",
                            "input" => "foreign",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name","menu_items"];
    public $fillable = ["name","levels"];
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
    public $has_many = [
            [
                "table" => "menu_items",
                "inverse" => false,
                "cascade" => false,
                "with" => true
            ],
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}