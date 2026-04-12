<?php

namespace Database\Seeders;

use App\Models\DriverProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@siri.id'], [
            'name'     => 'Admin Siri',
            'phone'    => '081200000001',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::firstOrCreate(['email' => 'user@siri.id'], [
            'name'      => 'User Demo',
            'phone'     => '081200000002',
            'password'  => Hash::make('password'),
            'role'      => 'user',
            'address'   => 'Jl. Sudirman No. 5, Jakarta Pusat',
            'latitude'  => -6.2088,
            'longitude' => 106.8456,
        ]);

        User::firstOrCreate(['email' => 'user2@siri.id'], [
            'name'      => 'Budi Santoso',
            'phone'     => '081200000005',
            'password'  => Hash::make('password'),
            'role'      => 'user',
            'address'   => 'Jl. Thamrin No. 10, Jakarta Pusat',
            'latitude'  => -6.1944,
            'longitude' => 106.8229,
        ]);

        $drivers = [
            [
                'user' => [
                    'name' => 'Driver Demo', 'email' => 'driver@siri.id',
                    'phone' => '081200000003', 'password' => Hash::make('password'), 'role' => 'driver',
                ],
                'profile' => ['vehicle_type' => 'motor', 'license_plate' => 'B 1234 XYZ', 'status' => 'online'],
            ],
            [
                'user' => [
                    'name' => 'Agus Supriadi', 'email' => 'driver2@siri.id',
                    'phone' => '081200000004', 'password' => Hash::make('password'), 'role' => 'driver',
                ],
                'profile' => ['vehicle_type' => 'motor', 'license_plate' => 'B 5678 ABC', 'status' => 'online'],
            ],
            [
                'user' => [
                    'name' => 'Rudi Hartono', 'email' => 'driver3@siri.id',
                    'phone' => '081200000006', 'password' => Hash::make('password'), 'role' => 'driver',
                ],
                'profile' => ['vehicle_type' => 'mobil', 'license_plate' => 'B 9999 DEF', 'status' => 'offline'],
            ],
        ];

        foreach ($drivers as $d) {
            $driver = User::firstOrCreate(['email' => $d['user']['email']], $d['user']);
            DriverProfile::firstOrCreate(['user_id' => $driver->id], $d['profile']);
        }
    }
}
