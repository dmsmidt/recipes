<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        $insert = [
             [
             "configuration_id" => "6",
             "string" => null,
             "text" => null,
             "boolean" => true,
             "integer" => null,
             "float" => null,
             "datetime" => null,
             "timestamp" => null,
             ],
             [
             "configuration_id" => "7",
             "string" => null,
             "text" => null,
             "boolean" => true,
             "integer" => null,
             "float" => null,
             "datetime" => null,
             "timestamp" => null,
             ],

        ];
        DB::table('settings')->insert($insert);
    }
}
