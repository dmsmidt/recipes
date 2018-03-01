<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImageTemplate extends Recipe{

    use Ingredients;

    public $moduleName = 'image_templates';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 255,
                            "unique" => 1,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
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
    public $activatable = false;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;
    public $has_many = [
            [
                "table" => "images",
                "inverse" => false,
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