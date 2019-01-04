<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImageFormat extends Recipe
{

    use Ingredients;

    public $moduleName = 'image_formats';
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
            "input" => "text",
            "rule" => "required",
        ],
        "name" => [
            "type" => "varchar",
            "length" => 100,
            "label" => "Name",
            "input" => "text",
            "rule" => "required",
        ],
        "x" => [
            "type" => "integer",
            "default" => "0",
            "label" => "X-position",
            "input" => "text",
        ],
        "y" => [
            "type" => "integer",
            "default" => "0",
            "label" => "Y-position",
            "input" => "text",
        ],
        "width" => [
            "type" => "integer",
            "label" => "Width",
            "input" => "text",
            "rule" => "required",
        ],
        "height" => [
            "type" => "integer",
            "label" => "Height",
            "input" => "text",
            "rule" => "required",
        ],
        "minimum_size" => [
            "type" => "boolean",
            "default" => "0",
            "label" => "Minimum size required",
            "input" => "checkbox",
        ],
        "scaling" => [
            "type" => "varchar",
            "length" => 10,
            "default" => "fit",
            "nullable" => 1,
            "label" => "Cropping and scaling",
            "input" => "select",
            "options" => [
                [
                    "text" => "Best fit",
                    "value" => "fit"
                ],
                [
                    "text" => "Crop",
                    "value" => "crop"
                ],
            ]
        ],
        "image_id" => [
            "type" => "integer",
            "unsigned" => 1,
            "nullable" => 1,
        ],
        "constraint" => [
            "type" => "boolean",
            "default" => "0",
            "nullable" => 1,
            "label" => "Constraint proportions",
            "input" => "checkbox",
        ],
    ];
    public $hidden = [];
    public $summary = ["image_template", "name", "width", "height"];
    public $fillable = ["image_template", "name", "x", "y", "width", "height", "scaling", "image_id", "constraint", "minimum_size"];
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
            "cascade" => true,
            "with" => false
        ],
    ];

    /**
     * @return mixed
     */
    public function __construct()
    {
        return (object)$this;
    }

}