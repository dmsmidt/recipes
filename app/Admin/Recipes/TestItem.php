<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class TestItem extends Recipe{

    use Ingredients;

    public $moduleName = 'test_items';
    public $table = 'test_items';
    public $parent_table = 'tests';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "test_id" => [
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
    public $summary = ["name","icon","text"];
    public $fillable = ["test_id","name","icon","url"];
    public $guarded = ["id"];
    public $scoped = ["test_id"];
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
                "table" => "test_items_lang",
                "inverse" => false,
                "cascade" => true
            ],    [
                "table" => "tests",
                "inverse" => true,
                "cascade" => true
            ],
    ];
    public $many_many = [
            [
                "table" => "roles",
                "cascade" => false
            ],
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}