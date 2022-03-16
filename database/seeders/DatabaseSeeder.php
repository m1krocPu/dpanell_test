<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dp_users')->insert([
            'users_name' => "Administrator",
            'users_email' => 'admin@dpanell.com',
            'users_pwd' => Hash::make('12345678'),
            'users_level' => 'admin',
        ]);
    }
}
