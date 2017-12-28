<?php

use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
             "menu_id" => "1",
             "name" => "dashboard",
             "icon" => "fa-bar-chart",
             "url" => "/admin/dashboard",
             "parent_id" => null,
             "lft" => "1",
             "rgt" => "2",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "configurations",
             "icon" => "fa-gocs",
             "url" => "/admin/configurations",
             "parent_id" => null,
             "lft" => "3",
             "rgt" => "4",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "settings",
             "icon" => "fa-cog",
             "url" => "/admin/settings",
             "parent_id" => null,
             "lft" => "5",
             "rgt" => "6",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "users",
             "icon" => "fa-users",
             "url" => "/admin/users",
             "parent_id" => null,
             "lft" => "7",
             "rgt" => "8",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "menus",
             "icon" => "fa-bars",
             "url" => "/admin/menus",
             "parent_id" => null,
             "lft" => "9",
             "rgt" => "10",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "roles",
             "icon" => "fa-unlock-alt",
             "url" => "/admin/roles",
             "parent_id" => null,
             "lft" => "11",
             "rgt" => "12",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],
             [
             "menu_id" => "1",
             "name" => "recipes",
             "icon" => "fa-book",
             "url" => "/admin/recipes",
             "parent_id" => null,
             "lft" => "13",
             "rgt" => "14",
             "level" => "0",
             "active" => "1",
             "protect" => "0",
             ],

        ];
        DB::table('menu_items')->insert($insert);
    }
}
