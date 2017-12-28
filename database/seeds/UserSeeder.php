<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "role_id" => "1",
                "name" => "Patrick Zuurbier",
                "username" => "developer",
                "email" => "patrickzuurbier@gmail.com",
                "password" => "$2y$10$/YAcW6zAvqMkKlwrTvO0Y.jVy5YdhCAY72y7dErsUw4TP8BzRjyuy",
                "language" => "nl",
                "remember_token" => null,
            ],
        ];

        DB::table('users')->insert($users);

    }
}
