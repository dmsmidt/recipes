<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Dashboard  extends Recipe{

    use Ingredients;

    public $moduleName = 'dashboard';
    public $table = "dashboard";
    public $fields = [
        "id"=>[
            "type"=>"increments"
        ],
        "name"=>[
            "type"=>"varchar",
            "length"=>50,
            "label" => "Name",
            "input" => "text",
            "rule" => "required",
        ],
    ];
    public $hidden = [];
    public $fillable = ["name"];
    public $guarded = [];
    public $scoped = [];
    public $summary = ["name"];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $sortable = false;
    public $nestable = false;
    public $activatable = true;
    public $protectable = true;
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }


}
