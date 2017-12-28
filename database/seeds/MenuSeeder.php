<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
             "name" => "Cms",
             "levels" => "1",
             "parent_id" => null,
             "lft" => "1",
             "rgt" => "2",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],

        ];
        DB::table('menus')->insert($insert);
    }
}
