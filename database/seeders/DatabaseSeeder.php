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

        User::firstOrCreate([
            'name' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'password' => 'test'
        ], [
            'role' => User::ADMIN
        ]);

        User::firstOrCreate([
            'name' => 'Test App',
            'email' => 'test@gmail.com',
            'password' => 'test',
        ], [
            'role' => User::TEST
        ]);
    }
}
