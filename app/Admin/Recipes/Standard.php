<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Standard  extends Recipe{

    use Ingredients;

    public $moduleName = '';
    public $table = '';
    public $fields = [
        "id"=>[
            "type"=>"increments",
            "input"=>"hidden"
        ],
        "name" => [
            "type" => "varchar",
            "length" => 255,
            "unique" => 1,
            "label" => "Name",
            "input" => "text",
        ],
    ];
    public $hidden = [];
    public $fillable = ["name"];
    public $guarded = ["id"];
    public $summary = ["name"];
    public $scoped = [];
    public $has_one = [];
    public $has_many = [];
    public $many_many = [];
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
