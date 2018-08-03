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
            "image" => [
                            "type" => "foreign",
                            "label" => "Image",
                            "image_template" => "news",
                            "input" => "image",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name"];
    public $fillable = ["name"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = false;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;
    public $many_many = [
            [
                "table" => "images",
                "cascade" => true,
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