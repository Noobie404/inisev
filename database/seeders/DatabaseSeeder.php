<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"      => "user",
            "email"     => "user@gmail.com",
            "password"  => bcrypt("123456"),
        ]);
        Website::create(
            [
                "name"      => "WEBSITE 1",
            ]
        );
    }
}
