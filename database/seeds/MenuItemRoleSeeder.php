<?php

use Illuminate\Database\Seeder;

class MenuItemRoleSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
             "menu_item_id" => "1",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "2",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "3",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "4",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "5",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "6",
             "role_id" => "1",
             ],
             [
             "menu_item_id" => "7",
             "role_id" => "1",
             ],

        ];
        DB::table('menu_items_roles')->insert($insert);
    }
}
