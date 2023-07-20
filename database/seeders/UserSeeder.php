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
            'wa'        => '08222588822',
            'kota_id'   => 76,
            'address'   => 'Jl Bekasi No 1',
        ]);

        $user = User::create([
            'name'      => 'User',
            'email'     => 'user@gmail.com',
            'password'  => Hash::make('user12345'),
            'role'      => 'user',
            'wa'        => '086955526269',
            'kota_id'   => 2,
            'address'   => 'Jl Bandung No 1',
        ]);
    }
}
