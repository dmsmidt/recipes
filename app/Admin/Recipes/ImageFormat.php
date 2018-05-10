<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImageFormat extends Recipe{

    use Ingredients;

    public $moduleName = 'image_formats';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "image_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "nullable" => 1,
                        ],
            "image_template_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "nullable" => 1,
                            "label" => "Template",
                            "input" => "select",
                            "options" => [
                                "table" => "image_templates",
                                "text" => "name",
                                "value" => "id",
                                "group_by" => "",
                                "filter_by" => ""            ]
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 100,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "x" => [
                            "type" => "double",
                            "length" => 15,
                            "decimals" => 10,
                            "default" => "0",
                            "nullable" => 1,
                            "label" => "X-position",
                            "input" => "text",
                        ],
            "y" => [
                            "type" => "double",
                            "length" => 15,
                            "decimals" => 10,
                            "default" => "0",
                            "nullable" => 1,
                            "label" => "Y-position",
                            "input" => "text",
                        ],
            "width" => [
                            "type" => "double",
                            "length" => 15,
                            "decimals" => 10,
                            "label" => "Width",
                            "input" => "text",
                        ],
            "height" => [
                            "type" => "double",
                            "length" => 15,
                            "decimals" => 10,
                            "label" => "Height",
                            "input" => "text",
                        ],
            "scaling" => [
                            "type" => "varchar",
                            "length" => 10,
                            "default" => "fit",
                            "nullable" => 1,
                            "label" => "Scaling",
                            "input" => "select",
                            "options" => [
                                [
                                    "text" => "Best fit",
                                    "value" => "fit"
                                ],
                                [
                                    "text" => "Crop",
                                    "value" => "crop"
                                ],            ]
                        ],
    ];
    public $hidden = [];
    public $summary = ["image_template_id","name","width","height"];
    public $fillable = ["image_id","image_template_id","name","x","y","width","height","scaling"];
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
    public $has_many = [
            [
                "table" => "images",
                "inverse" => true,
                "cascade" => false
            ],    [
                "table" => "image_templates",
                "inverse" => true,
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