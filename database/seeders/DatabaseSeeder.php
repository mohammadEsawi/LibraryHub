<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'role' => 'admin',
        ], [
            'name' => 'Platform Admin',
            'email' => 'mhmd@gmail.com',
            'phone' => '0598032500',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::updateOrCreate([
            'email' => 'reader@libraryhub.test',
        ], [
            'name' => 'Reader User',
            'role' => 'reader',
            'password' => 'password',
        ]);

        User::updateOrCreate([
            'email' => 'customer@libraryhub.test',
        ], [
            'name' => 'Customer User',
            'role' => 'customer',
            'password' => 'password',
        ]);

        User::updateOrCreate([
            'email' => 'author@libraryhub.test',
        ], [
            'name' => 'Author User',
            'role' => 'author',
            'password' => 'password',
        ]);
    }
}
