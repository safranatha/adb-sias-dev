<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Direktur',
            'email' => 'direktur@dir.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Assisten Direktur',
            'email' => 'assdir@dir.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Manager Teknik',
            'email' => 'mt@teknik.com',
            'password' => Hash::make('password123'),
        ]);
        
        User::create([
            'name' => 'Manager Admin',
            'email' => 'madm@admin.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Staff Teknik',
            'email' => 'staffteknik@teknik.com',
            'password' => Hash::make('password123'),
        ]);


        User::create([
            'name' => 'Staff Admin',
            'email' => 'staffadm@adm.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
