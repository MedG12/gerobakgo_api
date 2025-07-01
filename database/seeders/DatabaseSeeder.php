<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'name' => 'Test Merchant 1',
                'email' => 'merchant1@example.com',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ],
            [
                'name' => 'Merchant 2',
                'email' => 'merchant2@example.com',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ],
            [
                'name' => 'Merchant 3',
                'email' => 'merchant3@example.com',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'User 3',
                'email' => 'user3@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        $this->call([
            MerchantSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
