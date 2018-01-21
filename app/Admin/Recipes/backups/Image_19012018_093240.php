<?php

namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Image  extends Recipe{

    use Ingredients;

    public $moduleName = 'images';
    public $table = 'images';
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
            "template" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Template",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "alt" => [
                            "type" => "foreign",
                            "label" => "Alt",
                            "input" => "language",
                        ],
            "header_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "nullable" => 1,
                            "input" => "hidden",
                        ],
    ];
    public $hidden = [];
    public $summary = ["filename","template"];
    public $fillable = ["filename","template","header_id"];
    public $guarded = ["id"];
    public $scoped = ["header_id"];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = true;
    public $has_one = [
        
            "header_id" => "headers.id",
    ];
    public $has_many = [
        
            "formats" => "image_formats.image_id",
            "alt" => "images_lang.image_id",
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}