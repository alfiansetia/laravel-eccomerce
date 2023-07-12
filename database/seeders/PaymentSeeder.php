<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'name'       => 'BRI',
            'acc_name'   => 'PT Bengkel',
            'acc_number' => '525551115582552',
        ]);
        Payment::create([
            'name'       => 'BCA',
            'acc_name'   => 'PT Bengkel',
            'acc_number' => '221112521',
        ]);
        Payment::create([
            'name'       => 'MANDIRI',
            'acc_name'   => 'PT Bengkel',
            'acc_number' => '522251441',
        ]);
    }
}
