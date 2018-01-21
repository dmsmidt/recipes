<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class Setting extends Recipe{

    use Ingredients;

    public $moduleName = 'settings';
    public $table = 'settings';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                        ],
            "configuration_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "input" => "hidden",
                        ],
            "string" => [
                            "type" => "varchar",
                            "length" => 255,
                            "nullable" => 1,
                        ],
            "text" => [
                            "type" => "text",
                            "nullable" => 1,
                        ],
            "boolean" => [
                            "type" => "boolean",
                            "nullable" => 1,
                        ],
            "integer" => [
                            "type" => "integer",
                            "nullable" => 1,
                        ],
            "float" => [
                            "type" => "float_number",
                            "nullable" => 1,
                        ],
            "datetime" => [
                            "type" => "datetime",
                            "nullable" => 1,
                        ],
            "timestamp" => [
                            "type" => "timestamp",
                            "nullable" => 1,
                        ],
    ];
    public $hidden = [];
    public $summary = ["string","text","boolean","integer","float","datetime","timestamp"];
    public $fillable = ["configuration_id","string","text","boolean","integer","float","datetime","timestamp"];
    public $guarded = ["id"];
    public $scoped = [];
    public $add = false;
    public $edit = true;
    public $delete = false;
    public $activatable = false;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = false;
    public $has_one = [
        [
            "table" => "configurations",
            "inverse" => false
        ]
    ];

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}