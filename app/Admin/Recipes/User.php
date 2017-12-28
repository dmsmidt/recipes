<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class User  extends Recipe{

    use Ingredients;

    public $moduleName = 'users';
    public $table = 'users';
    public $fields = [
        "id"=>[
            "type"=>"increments",
        ],
        "role_id"=>[
            "type"=>"integer",
            "unsigned"=>true,
            "label"=>"Role",
            "input"=>"select",
            "rule"=>"numeric",
            "options"=>[
                "table" => "roles",
                "text" => "name",
                "value" => "id"
            ]
        ],
        "name"=>[
            "type"=>"varchar",
            "length"=> 50,
            "label" => "Name",
            "input" => "text",
            "rule" => "required"
        ],
        "username"=>[
            "type"=>"varchar",
            "length"=> 50,
            "unique"=> true,
            "label" => "Username",
            "input" => "text",
            "rule" => "required|unique:users,username"
        ],
        "email"=>[
            "type"=>"email",
            "length"=> 128,
            "unique"=> true,
            "label" => "E-mail",
            "input" => "email",
            "rule" => "required|email|unique:users,email"
        ],
        "password"=>[
            "type"=>"password",
            "label" => "Password",
            "input" => "password",
            "rule" => "required|min:8|confirmed"
        ],
        "password_confirmation"=>[
            "label" => "Re-type password",
            "input" => "password",
            "rule" => "required"
        ],
        "language"=>[
            "type"=>"varchar",
            "length"=> 10,
            "nullable"=> true,
            "label" => "Language",
            "input" => "select",
            "options" => [
                [
                    "text" => "NL",
                    "value" => "nl"
                ],
                [
                    "text" => "EN",
                    "value" => "en"
                ]
            ]
        ],
        "remember_token"=>[
            "type"=>"varchar",
            "length"=> 100,
            "nullable"=> true,
        ]
    ];
    public $hidden = ["password","remember_token"];
    public $fillable = ["name","username","email","password","language","role_id"];
    public $guarded = [];
    public $scoped = [];
    public $summary = ["name","username"];
    public $has_one = [
        "role_id" => "roles.id",
    ];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $sortable = false;
    public $nestable = false;
    public $activatable = false;
    public $protectable = false;
    public $timestamps = true;

    /**
     * @return mixed
     */
    public function __construct(){
        return (object)$this;
    }

}
