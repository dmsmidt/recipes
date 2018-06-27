<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImagesLang extends Recipe{

    use Ingredients;

    public $moduleName = 'images_lang';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "image_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "input" => "hidden",
                        ],
            "language_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "input" => "hidden",
                        ],
            "alt" => [
                            "type" => "varchar",
                            "length" => 255,
                            "nullable" => 1,
                            "label" => "Alt",
                            "input" => "text",
                        ],
    ];
    public $hidden = [];
    public $summary = [];
    public $fillable = ["image_id","language_id","alt"];
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
            ],    [
                "table" => "languages",
                "inverse" => true,
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