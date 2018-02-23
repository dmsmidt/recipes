<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class MenuItem extends Recipe{

    use Ingredients;

    public $moduleName = 'menu_items';
    public $table = 'menu_items';
    public $parent_table = 'menus';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
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
                            "type" => "foreign",
                            "label" => "Text",
                            "input" => "language",
                        ],
            "roles" => [
                            "type" => "foreign",
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
                "inverse" => false
            ],    [
                "table" => "menus",
                "inverse" => true
            ],
    ];
    public $many_many = [
            [
                "table" => "roles"
            ],
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}