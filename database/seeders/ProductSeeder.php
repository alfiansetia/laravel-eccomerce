<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name'          => 'Spackbor Depan Yamaha Fiz R',
            'kategori_id'   => 2,
            'supplier_id'   => 2,
            'harga_jual'    => 100000,
            'harga_beli'    => 80000,
            'berat'         => 100,
        ]);
    }
}
