<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class ImageFormat  extends Recipe{

    use Ingredients;

    public $moduleName = 'image_formats';
    public $table = 'image_formats';
    public $fields = [
        "id" => [
            "type"=>"increments",
        ],
        "image_id" => [
            "type"=>"integer",
            "unsigned"=>true,
            "input"=>"hidden"
        ],
        "name" => [
            "type"=>"varchar",
            "length"=> 100,
            "label" => "Name",
            "input" => "text",
            "rule" => "required"
        ],
        "x" => [
            "type" => "double",
            "label" => "X-position",
            "input" => "text",
            "length" => 15,
            "decimals" => 10,
            "default" => 0
        ],
        "y" => [
            "type" => "double",
            "label" => "Y-position",
            "input" => "text",
            "length" => 15,
            "decimals" => 10,

            "default" => 0
        ],
        "width" => [
            "type" => "double",
            "label" => "Width",
            "input" => "text",
            "length" => 15,
            "decimals" => 10,

            "default" => 0
        ],
        "height" => [
            "type" => "double",
            "label" => "Height",
            "input" => "text",
            "length" => 15,
            "decimals" => 10,
            "default" => 0
        ]
    ];
    public $hidden = [];
    public $fillable = ["image_id","x","y","width","height"];
    public $guarded = ["id"];
    public $summary = [];
    public $has_many = [
        [
            "table" => "images",
            "inverse" => true
        ]
    ];
    public $add = true;
    public $edit = true;
    public $delete = false;
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
