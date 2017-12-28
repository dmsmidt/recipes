<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
                "name" => "Developer",
             ],
             [
                 "name" => "Administrator",
             ],
        ];
        DB::table('roles')->insert($insert);
    }
}
