<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name'  => 'PT Astra',
            'telp'  => '082132225525',
            'address' => 'Jl Pegangsaan Dua'
        ]);

        Supplier::create([
            'name'  => 'PT Yamaha',
            'telp'  => '08252255855',
            'address' => 'Jl Cikarang Utama'
        ]);

        Supplier::create([
            'name'  => 'PT Suzuki',
            'telp'  => '08225542225',
            'address' => 'Jl Jababeka Raya'
        ]);
    }
}
