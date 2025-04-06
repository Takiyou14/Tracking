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
            'name' => 'Abdelkader Berkani',
            'email' => 'aekberkani0@gmail.com',
            'password' => bcrypt('28013662'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Employee1',
            'email' => 'employee1@airport.com',
            'password' => bcrypt('password'),
            'role' => 'taker',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Employee2',
            'email' => 'employee2@airport.com',
            'password' => bcrypt('password'),
            'role' => 'security',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Employee3',
            'email' => 'employee3@airport.com',
            'password' => bcrypt('password'),
            'role' => 'loader',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Employee4',
            'email' => 'employee4@airport.com',
            'password' => bcrypt('password'),
            'role' => 'arriver',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Takiyou',
            'email' => 'mohamedbrk147@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
