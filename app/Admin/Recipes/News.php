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
            "image" => [
                            "type" => "foreign",
                            "relation" => "images",
                            "label" => "Image",
                            "max_files" => "1",
                            "image_template" => "news",
                            "input" => "images",
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
    public $activatable = true;
    public $protectable = false;
    public $sortable = true;
    public $nestable = false;
    public $timestamps = true;
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