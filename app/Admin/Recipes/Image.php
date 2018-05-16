<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Image extends Recipe{

    use Ingredients;

    public $moduleName = 'images';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "image_template_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "label" => "Template",
                            "input" => "select",
                            "rule" => "required",
                            "options" => [
                                "table" => "image_templates",
                                "text" => "name",
                                "value" => "id",
                                "group_by" => "",
                                "filter_by" => ""            ]
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
    public $summary = ["image_template_id","filename"];
    public $fillable = ["image_template_id","filename"];
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
                "with" => false
            ],    [
                "table" => "images_lang",
                "inverse" => false,
                "cascade" => false,
                "with" => true
            ],    [
                "table" => "image_templates",
                "inverse" => true,
                "cascade" => false,
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