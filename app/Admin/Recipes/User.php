<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class User extends Recipe{

    use Ingredients;

    public $moduleName = 'users';
    public $parent = '';
    public $fields = [
    
            "id" => [
                            "type" => "increments",
                            "input" => "hidden",
                        ],
            "role_id" => [
                            "type" => "integer",
                            "unsigned" => 1,
                            "label" => "Role",
                            "input" => "select",
                            "rule" => "numeric",
                            "options" => [
                                "table" => "roles",
                                "text" => "name",
                                "value" => "id",
                                "group_by" => "",
                                "filter_by" => ""            ]
                        ],
            "name" => [
                            "type" => "varchar",
                            "length" => 50,
                            "label" => "Name",
                            "input" => "text",
                            "rule" => "required",
                        ],
            "username" => [
                            "type" => "varchar",
                            "length" => 50,
                            "unique" => 1,
                            "label" => "Username",
                            "input" => "text",
                            "rule" => "required|unique:users,username",
                        ],
            "email" => [
                            "type" => "email",
                            "length" => 128,
                            "unique" => 1,
                            "label" => "E-mail",
                            "input" => "email",
                            "rule" => "required|unique:users,email|email",
                        ],
            "password" => [
                            "type" => "password",
                            "label" => "Password",
                            "input" => "password",
                            "rule" => "required|confirmed|min:8",
                        ],
            "password_confirmation" => [
                            "label" => "Re-type password",
                            "input" => "password",
                            "rule" => "required",
                        ],
            "language" => [
                            "type" => "varchar",
                            "length" => 10,
                            "nullable" => 1,
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
                                ],            ]
                        ],
            "remember_token" => [
                            "type" => "varchar",
                            "length" => 100,
                            "nullable" => 1,
                        ],
    ];
    public $hidden = ["password","remember_token"];
    public $summary = ["name","username"];
    public $fillable = ["role_id","name","username","email","password","language"];
    public $guarded = [];
    public $scoped = [];
    public $add = true;
    public $edit = true;
    public $delete = true;
    public $activatable = false;
    public $protectable = false;
    public $sortable = false;
    public $nestable = false;
    public $timestamps = true;
    public $has_many = [
            [
                "table" => "roles",
                "inverse" => true,
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