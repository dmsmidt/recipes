<?php

use Illuminate\Database\Seeder;

class MenuItemsLangSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
             "menu_item_id" => "1",
             "language_id" => "1",
             "text" => "Dashboard",
             ],
             [
             "menu_item_id" => "1",
             "language_id" => "2",
             "text" => "Dashboard",
             ],
             [
             "menu_item_id" => "2",
             "language_id" => "1",
             "text" => "Configuratie",
             ],
             [
             "menu_item_id" => "2",
             "language_id" => "2",
             "text" => "Configuration",
             ],
             [
             "menu_item_id" => "3",
             "language_id" => "1",
             "text" => "Instellingen",
             ],
             [
             "menu_item_id" => "3",
             "language_id" => "2",
             "text" => "Settings",
             ],
             [
             "menu_item_id" => "4",
             "language_id" => "1",
             "text" => "Gebruikers",
             ],
             [
             "menu_item_id" => "4",
             "language_id" => "2",
             "text" => "Users",
             ],
             [
             "menu_item_id" => "5",
             "language_id" => "1",
             "text" => "Menu's",
             ],
             [
             "menu_item_id" => "5",
             "language_id" => "2",
             "text" => "Menus",
             ],
             [
             "menu_item_id" => "6",
             "language_id" => "1",
             "text" => "Rollen",
             ],
             [
             "menu_item_id" => "6",
             "language_id" => "2",
             "text" => "Roles",
             ],
             [
             "menu_item_id" => "7",
             "language_id" => "1",
             "text" => "Recepten",
             ],
             [
             "menu_item_id" => "7",
             "language_id" => "2",
             "text" => "Recipes",
             ],

        ];
        DB::table('menu_items_lang')->insert($insert);
    }
}
