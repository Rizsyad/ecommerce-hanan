<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "email" => "admin@localhost.com",
                "name" => "admin",
                "password" => bcrypt("admin")
            ],
            [
            "email" => "user@localhost.com",
                "name" => "user",
                "password" => bcrypt("user")
            ]
        ];

        User::insert($data);
    }
}
