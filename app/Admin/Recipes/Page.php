<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Page extends Recipe{

    use Ingredients;

    public $moduleName = 'pages';
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
        ],

        "html" => [
                            "type" => "text",
                            "label" => "Html",
                            "input" => "html",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name"];
    public $fillable = ["html","name"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = true;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}