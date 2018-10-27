<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class MenuItem extends Recipe{

    use Ingredients;

    public $moduleName = 'menu_items';
    public $parent = 'menus';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "menu_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "input" => "hidden",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "icon" => [
                            "type" => "varchar",
                            "length" => 50,
                            "nullable" => 1,
                            "label" => "Icon",
                            "input" => "icon",
                        ],
            "url" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Url",
                            "input" => "text",
                        ],
            "text" => [
                            "type" => "translation",
                            "label" => "Text",
                            "input" => "text",
                        ],
            "roles" => [
                            "type" => "foreign",
                            "relation" => "roles",
                            "label" => "Roles",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name","icon"];
    public $fillable = ["menu_id","name","icon","url"];
    public $guarded = ["id"];
    public $scoped = ["menu_id"];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = false;
    public $nestable = true;
    public $timestamps = false;
    public $has_many = [
            [
                "table" => "menu_items_lang",
                "inverse" => false,
                "cascade" => true,
                "with" => true
            ],    [
                "table" => "menus",
                "inverse" => true,
                "cascade" => false,
                "with" => false
            ],
    ];
    public $many_many = [
            [
                "table" => "roles",
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