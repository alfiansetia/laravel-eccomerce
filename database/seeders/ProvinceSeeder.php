<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::create([
            'name' => 'Jawa Barat'
        ]);
        Province::create([
            'name' => 'Jawa Tengah'
        ]);
        Province::create([
            'name' => 'Jawa Timur'
        ]);
    }
}
