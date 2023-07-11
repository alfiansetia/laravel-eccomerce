<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('admin12345'),
            'role'      => 'admin',
        ]);

        $user = User::create([
            'name'      => 'Admin',
            'email'     => 'user@gmail.com',
            'password'  => Hash::make('user12345'),
            'role'      => 'user',
        ]);
    }
}