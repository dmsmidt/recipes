<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ["name" => "Nederlands",
            "abbr" => "nl",
            "default" => "1",
            "parent_id" => null,
            "lft" => "1",
            "rgt" => "2",
            "level" => "0",
            "active" => "1",
            "protect" => "0"],

            ["name" => "English",
            "abbr" => "en",
            "default" => "0",
            "parent_id" => null,
            "lft" => "3",
            "rgt" => "4",
            "level" => "0",
            "active" => "1",
            "protect" => "0"],

            ["name" => "Deutch",
            "abbr" => "de",
            "default" => "0",
            "parent_id" => null,
            "lft" => "5",
            "rgt" => "6",
            "level" => "0",
            "active" => "0",
            "protect" => "0"],

            ["name" => "Francais",
            "abbr" => "fr",
            "default" => "0",
            "parent_id" => null,
            "lft" => "7",
            "rgt" => "8",
            "level" => "0",
            "active" => "0",
            "protect" => "0"],

            ["name" => "Español",
            "abbr" => "es",
            "default" => "0",
            "parent_id" => null,
            "lft" => "9",
            "rgt" => "10",
            "level" => "0",
            "active" => "0",
            "protect" => "0"],
        ];

        DB::table('languages')->insert($languages);
    }
}
