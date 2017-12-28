<?php

use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = [
            [
                "name" => "languages",
                "label" => "Languages",
                "input_type" => "",
                "value_type" => "",
                "options" => "",
                "is_header" => true,
                "parent_id" => null,
                "lft" => "1",
                "rgt" => "2",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
            [
                "name" => "nl",
                "label" => "nl",
                "input_type" => "checkbox",
                "value_type" => "boolean",
                "options" => "",
                "is_header" => false,
                "parent_id" => null,
                "lft" => "3",
                "rgt" => "4",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
            [
                "name" => "en",
                "label" => "en",
                "input_type" => "checkbox",
                "value_type" => "boolean",
                "options" => "",
                "is_header" => false,
                "parent_id" => null,
                "lft" => "5",
                "rgt" => "6",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
            [
                "name" => "de",
                "label" => "de",
                "input_type" => "checkbox",
                "value_type" => "boolean",
                "options" => "",
                "is_header" => false,
                "parent_id" => null,
                "lft" => "7",
                "rgt" => "8",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
            [
                "name" => "es",
                "label" => "es",
                "input_type" => "checkbox",
                "value_type" => "boolean",
                "options" => "",
                "is_header" => false,
                "parent_id" => null,
                "lft" => "9",
                "rgt" => "10",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
            [
                "name" => "fr",
                "label" => "fr",
                "input_type" => "checkbox",
                "value_type" => "boolean",
                "options" => "",
                "is_header" => false,
                "parent_id" => null,
                "lft" => "11",
                "rgt" => "12",
                "level" => "0",
                "active" => "1",
                "protect" => "1"
            ],
        ];
        DB::table('configurations')->insert($configurations);

    }
}
