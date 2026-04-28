<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Pesan Makanan', 'slug' => 'food',     'base_price' => 5000,  'vehicle_type' => 'motor'],
            ['name' => 'Ojek',          'slug' => 'ojek',     'base_price' => 8000,  'vehicle_type' => 'motor'],
            ['name' => 'Mobil',         'slug' => 'car',      'base_price' => 15000, 'vehicle_type' => 'mobil'],
            ['name' => 'Kirim Paket',   'slug' => 'delivery', 'base_price' => 10000, 'vehicle_type' => 'motor'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
