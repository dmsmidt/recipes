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
            "filename" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "image_template_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "rule" => "required",
                        ],
            "alt" => [
                            "type" => "foreign",
                            "label" => "Alt",
                            "input" => "language",
                        ],
    ];
    public $hidden = [];
    public $summary = ["filename","image_template_id"];
    public $fillable = ["filename","image_template_id"];
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
                "cascade" => true
            ],    [
                "table" => "images_lang",
                "inverse" => false,
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