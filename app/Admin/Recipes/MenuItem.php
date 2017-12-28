<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class MenuItem extends Recipe{

    use Ingredients;

    public $moduleName = 'menu_items';
    public $table = "menu_items";
    public $fields = [
        "id"=>[
            "type"=>"increments"
        ],
        "menu_id"=>[
            "type"=>"integer",
            "unsigned"=>true,
            "input"=>"hidden"
        ],
        "name"=>[
            "type"=>"string",
            "length"=>50,
            "label" => "Name",
            "input" => "text",
            "rule" => "required",
        ],
        "icon"=>[
            "type"=>"string",
            "length"=>50,
            "label" => "Icon",
            "input" => "icon",
            "nullable" => true
        ],
        "url"=>[
            "type"=>"string",
            "length"=>255,
            "label" => "Url",
            "input" => "text",
        ],
        "text"=>[
            "type"=>"foreign",
            "label"=>"Text",
            "input"=>"language"
        ],
        "roles"=>[
            "type"=>"foreign",
            "label" => "Roles"
        ]
    ];
    public $hidden = [];
    public $fillable = ["menu_id","name","icon","url"];
    public $guarded = ["id","parent_id","lft","rgt","level"];
    public $scoped = ["menu_id"];//needed for multiple nested sets in one table
    public $summary = ["icon","name","text"];
    public $has_one = [
        "menu_id" => "menu.id"
    ];
    public $has_many = [
        "text" => "menu_items_lang.menu_item_id"
    ];
    public $many_many = [
        "roles" => "menu_items_roles.menu_item_id"
    ];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $sortable = false;
    public $nestable = true;
    public $activatable = true;
    public $protectable = true;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}
