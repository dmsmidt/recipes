<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Slideshow extends Recipe{

    use Ingredients;

    public $moduleName = 'slideshows';
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
            "images" => [
                            "type" => "foreign",
                            "label" => "Images",
                            "image_template" => "slideshow",
                            "input" => "image",
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
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;
    public $has_many = [
        
    ];
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