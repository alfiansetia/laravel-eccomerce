<?php

namespace Database\Seeders;

use App\Models\Kota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Kota::create([
            'name' => 'Bandung',
            'province_id' => 1
        ]);
        Kota::create([
            'name' => 'Semarang',
            'province_id' => 2
        ]);
        Kota::create([
            'name' => 'Malang',
            'province_id' => 3
        ]);
    }
}
