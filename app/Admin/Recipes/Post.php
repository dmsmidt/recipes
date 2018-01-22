<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Post extends Recipe{

    use Ingredients;

    public $moduleName = 'posts';
    public $table = 'posts';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "title" => [
                            "type" => "varchar",
                            "length" => 255,
                            "label" => "Title",
                            "input" => "text",
                        ],
            "text" => [
                            "type" => "text",
                            "label" => "Text",
                            "input" => "textarea",
                        ],
    ];
    public $hidden = [];
    public $summary = ["title"];
    public $fillable = ["title","text"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = true;
    public $nestable = false;
    public $timestamps = true;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}