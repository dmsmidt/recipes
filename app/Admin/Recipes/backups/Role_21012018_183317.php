<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Role extends Recipe{

    use Ingredients;

    public $moduleName = 'roles';
    public $table = 'roles';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "menu_items" => [
                            "type" => "foreign",
                            "label" => "Locked menu items",
                            "input" => "multiGroupedCheckbox",
                            "options" => [
                                "table" => "menu_items",
                                "text" => "name",
                                "value" => "id",
                                "group_by" => "menus.name",
                                "filter_by" => "menus.id = 1",
                            ]
                        ],
    ];
    public $hidden = [];
    public $summary = ["name"];
    public $fillable = ["name"];
    public $guarded = [];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = false;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;
    public $has_many = [
            [
                "table" => "users",
                "inverse" => false
            ],
    ];
    public $many_many = [
            [
                "table" => "menu_items"
            ],
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}