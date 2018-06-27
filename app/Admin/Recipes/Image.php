<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Image extends Recipe{

    use Ingredients;

    public $moduleName = 'images';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "image_template" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Template",
                            "input" => "hidden",
                            "rule" => "required",
                        ],
            "filename" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Filename",
                            "input" => "image",
                            "rule" => "required",
                        ],
            "alt" => [
                            "type" => "translation",
                            "label" => "Alt",
                            "input" => "text",
                        ],
    ];
    public $hidden = [];
    public $summary = ["image_template","filename"];
    public $fillable = ["image_template","filename"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = true;
    public $has_many = [
            [
                "table" => "image_formats",
                "inverse" => false,
                "cascade" => true,
                "with" => true
            ],    [
                "table" => "images_lang",
                "inverse" => false,
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