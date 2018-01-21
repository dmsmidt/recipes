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
            "type"=>"varchar",
            "length"=>50,
            "label" => "Name",
            "input" => "text",
            "rule" => "required",
        ],
        "icon"=>[
            "type"=>"varchar",
            "length"=>50,
            "label" => "Icon",
            "input" => "icon",
            "nullable" => true
        ],
        "url"=>[
            "type"=>"varchar",
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
    public $has_many = [
        [
            "table" => 'menu_items_lang',
            "inverse" => false
        ],
        [
            "table" => 'menus',
            "inverse" => true
        ]
    ];
    public $many_many = [
        [
            "table" => 'roles'
        ]
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
