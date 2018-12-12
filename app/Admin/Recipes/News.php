<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class News extends Recipe{

    use Ingredients;

    public $moduleName = 'news';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 255,
                            "unique" => 1,
                            "label" => "Name",
                            "input" => "text",
                        ],
            "main_image" => [
                            "type" => "foreign",
                            "relation" => "images",
                            "label" => "Main image",
                            "image_template" => "news_main",
                            "input" => "image",
                        ],
            "sub_image" => [
                            "type" => "foreign",
                            "relation" => "images",
                            "label" => "Sub image",
                            "image_template" => "news_sub",
                            "input" => "image",
                        ],
            "text" => [
                            "type" => "text",
                            "nullable" => 1,
                            "label" => "Text",
                            "input" => "html",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name"];
    public $fillable = ["name","text"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = false;
    public $sortable = true;
    public $nestable = false;
    public $timestamps = true;
    public $many_many = [
            [
                "table" => "images",
                "cascade" => true,
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