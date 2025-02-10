<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 1, //Admin
            'subscribed' => true,
        ]);

        User::create([
            'name' => 'Investor',
            'email' => 'investor@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 2, // Investor
            'subscribed' => true,
        ]);

        User::create([
            'name' => 'Content Creator',
            'email' => 'creator@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 4, //User
            'subscribed' => true,
        ]);
        User::create([
            'name' => 'Content Creator',
            'email' => 'creator2@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 4, //User
            'subscribed' => false,
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 4, //User
            'subscribed' => false,
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 4, //User
            'subscribed' => true,
        ]);
        User::create([
            'name' => 'Guest',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => 5, //Guest
            'subscribed' => true,
        ]);
    }
}
