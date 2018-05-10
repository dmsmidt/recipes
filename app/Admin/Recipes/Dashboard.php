<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Dashboard extends Recipe{

    use Ingredients;

    public $moduleName = 'dashboard';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
    ];
    public $hidden = [];
    public $summary = ["name"];
    public $fillable = ["name"];
    public $guarded = [];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = true;
    public $protectable = true;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}