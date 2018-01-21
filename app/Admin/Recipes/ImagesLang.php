<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImagesLang  extends Recipe{

    use Ingredients;

    public $moduleName = 'images_lang';
    public $table = 'images_lang';
    public $fields = [
        "id" => [
            "type"=>"increments",
        ],
        "image_id" => [
            "type"=>"integer",
            "unsigned"=>true,
            "input" => "hidden",
        ],
        "language_id"=>[
            "type"=>"integer",
            "unsigned"=>true,
            "input" => "hidden",
        ],
        "alt"=>[
            "type"=>"varchar",
            "length"=>255,
            "label" => "Alt",
            "input" => "text",
            "nullable" => true
        ]
    ];
    public $hidden = [];
    public $fillable = ["image_id","language_id","alt"];
    public $guarded = ["id"];
    public $summary = [];
    public $has_many = [
        [
            "table" => "images",
            "inverse" => true
        ],
        [
            "table" => "languages",
            "inverse" => true
        ]
    ];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $sortable = false;
    public $nestable = false;
    public $activatable = false;
    public $protectable = false;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}
