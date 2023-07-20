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
        $string = '[
            {
                "province_id": "1",
                "name": "Bali"
            },
            {
                "province_id": "2",
                "name": "Bangka Belitung"
            },
            {
                "province_id": "3",
                "name": "Banten"
            },
            {
                "province_id": "4",
                "name": "Bengkulu"
            },
            {
                "province_id": "5",
                "name": "DI Yogyakarta"
            },
            {
                "province_id": "6",
                "name": "DKI Jakarta"
            },
            {
                "province_id": "7",
                "name": "Gorontalo"
            },
            {
                "province_id": "8",
                "name": "Jambi"
            },
            {
                "province_id": "9",
                "name": "Jawa Barat"
            },
            {
                "province_id": "10",
                "name": "Jawa Tengah"
            },
            {
                "province_id": "11",
                "name": "Jawa Timur"
            },
            {
                "province_id": "12",
                "name": "Kalimantan Barat"
            },
            {
                "province_id": "13",
                "name": "Kalimantan Selatan"
            },
            {
                "province_id": "14",
                "name": "Kalimantan Tengah"
            },
            {
                "province_id": "15",
                "name": "Kalimantan Timur"
            },
            {
                "province_id": "16",
                "name": "Kalimantan Utara"
            },
            {
                "province_id": "17",
                "name": "Kepulauan Riau"
            },
            {
                "province_id": "18",
                "name": "Lampung"
            },
            {
                "province_id": "19",
                "name": "Maluku"
            },
            {
                "province_id": "20",
                "name": "Maluku Utara"
            },
            {
                "province_id": "21",
                "name": "Nanggroe Aceh Darussalam (NAD)"
            },
            {
                "province_id": "22",
                "name": "Nusa Tenggara Barat (NTB)"
            },
            {
                "province_id": "23",
                "name": "Nusa Tenggara Timur (NTT)"
            },
            {
                "province_id": "24",
                "name": "Papua"
            },
            {
                "province_id": "25",
                "name": "Papua Barat"
            },
            {
                "province_id": "26",
                "name": "Riau"
            },
            {
                "province_id": "27",
                "name": "Sulawesi Barat"
            },
            {
                "province_id": "28",
                "name": "Sulawesi Selatan"
            },
            {
                "province_id": "29",
                "name": "Sulawesi Tengah"
            },
            {
                "province_id": "30",
                "name": "Sulawesi Tenggara"
            },
            {
                "province_id": "31",
                "name": "Sulawesi Utara"
            },
            {
                "province_id": "32",
                "name": "Sumatera Barat"
            },
            {
                "province_id": "33",
                "name": "Sumatera Selatan"
            },
            {
                "province_id": "34",
                "name": "Sumatera Utara"
            }
        ]';
        $data = json_decode($string);
        foreach ($data as $item) {
            Province::create([
                'id'    => $item->province_id,
                'name'  => $item->name
            ]);
        }
        // Province::create([
        //     'name' => 'Jawa Barat'
        // ]);
        // Province::create([
        //     'name' => 'Jawa Tengah'
        // ]);
        // Province::create([
        //     'name' => 'Jawa Timur'
        // ]);
    }
}
