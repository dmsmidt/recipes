<?php namespace App\Admin\Recipes;

class Role  extends Recipe{

    public $moduleName = 'roles';
    public $table = 'roles';
    public $fields = [
        "id" => [
            "type"=>"increments",//lowercase string see app/Cms/Types for type
        ],
        "name" => [
            "type"=>"varchar",//lowercase string see app/Cms/Types for type
            "length"=> 50,//number
            "label" => "Name", //string form label default db=>name
            "input" => "text",//form input type default text
            "rule" => "required"//see laravel 5 validation rules default none
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
                "filter_by" => ["id","1"],
            ],
            "default" => "1"
        ]
    ];
    public $hidden = [];
    public $fillable = ["name"];
    public $guarded = [];
    public $summary = ["name"];
    public $has_many = [
        "users" => "users.role_id",
    ];
    public $many_many = [
        "menu_items" => "menu_items_roles.role_id"
    ];
    public $add = true;
    public $edit = true;
    public $delete = true;
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
