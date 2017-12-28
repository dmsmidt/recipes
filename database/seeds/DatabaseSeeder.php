<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ConfigurationSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MenuItemRoleSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(MenuItemsLangSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
