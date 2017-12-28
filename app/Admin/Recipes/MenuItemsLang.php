<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class MenuItemsLang  extends Recipe{

    use Ingredients;

    public $moduleName = 'menu_items_lang';
    public $table = 'menu_items_lang';
    public $fields = [
        "id"=>[
            "type"=>"increments"
        ],
        "menu_item_id"=>[
            "type"=>"integer",
            "unsigned"=>true,
            "input" => "hidden",
        ],
        "language_id"=>[
            "type"=>"integer",
            "unsigned"=>true,
            "input" => "hidden",
        ],
        "text"=>[
            "type"=>"string",
            "length"=>100,
            "label" => "Text",
            "input" => "text",
            "nullable" => true
        ]
    ];
    public $hidden = [];
    public $fillable = ["menu_item_id","language_id","text"];
    public $guarded = [];
    public $summary = [];
    public $has_one = [
        "menu_item_id" => "menu_items.id",
        "language_id" => "languages.id"
    ];
    public $add = true;
    public $sortable = false;
    public $nestable = false;
    public $activatable = false;
    public $protectable = false;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}
