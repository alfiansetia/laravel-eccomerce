<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name'      => 'Bengkel',
            'address'   => 'Jl Mbah pojok No 36',
            'telp'      => '082324129752',
            'kota_id'   => 151
        ]);
    }
}
