<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Language extends Recipe{

    use Ingredients;

    public $moduleName = 'languages';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 100,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "abbr" => [
                            "type" => "varchar",
                            "length" => 10,
                            "label" => "Abbreviation",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "default" => [
                            "type" => "boolean",
                            "default" => "0",
                            "label" => "Use as default",
                            "input" => "checkbox",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name","abbr"];
    public $fillable = ["name","abbr","default"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = true;
    public $nestable = false;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}