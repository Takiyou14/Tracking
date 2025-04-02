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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@airport.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Employee',
            'email' => 'employee@airport.com',
            'password' => bcrypt('password'),
            'role' => 'employee'
        ]);
    
        User::create([
            'name' => 'John Traveler',
            'email' => 'traveler@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
