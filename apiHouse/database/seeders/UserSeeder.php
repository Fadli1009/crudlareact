<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Fadli',
            'email' => 'fadli@gmail.com',
            'phone' => '0812312312',
            'role' => 'admin',
            'adress' => 'Kavling Hankam Joglo jakarta barat',
            'password' => bcrypt('secret')
        ]);
    }
}
