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
            ['name' => 'Pesan Makanan', 'slug' => 'food',     'icon' => 'food.png',     'base_price' => 5000],
            ['name' => 'Ojek',          'slug' => 'ojek',     'icon' => 'ojek.png',     'base_price' => 8000],
            ['name' => 'Mobil',         'slug' => 'car',      'icon' => 'car.png',      'base_price' => 15000],
            ['name' => 'Kirim Paket',   'slug' => 'delivery', 'icon' => 'delivery.png', 'base_price' => 10000],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
