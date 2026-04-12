<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\FoodOrderItem;
use App\Models\Order;
use App\Models\Service;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user    = User::where('email', 'user@siri.id')->first();
        $user2   = User::where('email', 'user2@siri.id')->first();
        $driver  = User::where('email', 'driver@siri.id')->first();
        $driver2 = User::where('email', 'driver2@siri.id')->first();

        $svcOjek     = Service::where('slug', 'ojek')->first();
        $svcMobil    = Service::where('slug', 'car')->first();
        $svcFood     = Service::where('slug', 'food')->first();
        $svcDelivery = Service::where('slug', 'delivery')->first();

        $storeWarung = Store::where('slug', 'warung-siri')->first();
        $storeBakso  = Store::where('slug', 'bakso-pak-kumis')->first();
        $storeGeprek = Store::where('slug', 'ayam-geprek-bu-sri')->first();

        // ── Topup transactions (harus ada saldo dulu) ─────────────────────
        foreach ([
            [$user->id,  500000],
            [$user->id,  300000],
            [$user2->id, 200000],
            [$user2->id, 500000],
        ] as [$uid, $amount]) {
            Transaction::create([
                'user_id'   => $uid,
                'order_id'  => null,
                'amount'    => $amount,
                'type'      => 'topup',
                'status'    => 'success',
                'reference' => 'TOPUP-' . strtoupper(Str::random(10)),
            ]);
        }

        // ── Completed ride orders ─────────────────────────────────────────
        $rideOrders = [
            [
                'user_id' => $user->id, 'driver_id' => $driver->id, 'service_id' => $svcOjek->id,
                'status' => 'completed', 'price' => 25000,
                'pickup_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'destination_location' => 'Jl. Gatot Subroto No. 20, Jakarta Selatan',
                'notes' => 'Tolong cepat ya',
            ],
            [
                'user_id' => $user->id, 'driver_id' => $driver->id, 'service_id' => $svcMobil->id,
                'status' => 'completed', 'price' => 150000,
                'pickup_location' => 'Jl. Thamrin No. 1, Jakarta Pusat',
                'destination_location' => 'Bandara Soekarno-Hatta, Tangerang',
                'notes' => null,
            ],
            [
                'user_id' => $user2->id, 'driver_id' => $driver2->id, 'service_id' => $svcOjek->id,
                'status' => 'completed', 'price' => 18000,
                'pickup_location' => 'Jl. Kebon Jeruk No. 10, Jakarta Barat',
                'destination_location' => 'Jl. Puri Indah No. 5, Jakarta Barat',
                'notes' => null,
            ],
            [
                'user_id' => $user->id, 'driver_id' => $driver2->id, 'service_id' => $svcDelivery->id,
                'status' => 'completed', 'price' => 30000,
                'pickup_location' => 'Jl. Mangga Dua No. 3, Jakarta Utara',
                'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'notes' => 'Paket fragile, hati-hati',
            ],
        ];

        foreach ($rideOrders as $data) {
            $order = Order::create($data);
            $this->makePayment($order, 'success');
        }

        // ── Completed food orders ─────────────────────────────────────────
        $foodOrders = [
            [
                'order' => [
                    'user_id' => $user->id, 'driver_id' => $driver->id, 'service_id' => $svcFood->id,
                    'status' => 'completed', 'price' => 57000,
                    'pickup_location' => 'Warung Siri, Jl. Sudirman No. 10',
                    'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                    'notes' => 'Jangan lupa sendok',
                ],
                'items' => [
                    ['store' => $storeWarung, 'name' => 'Nasi Goreng Spesial', 'qty' => 2],
                    ['store' => $storeWarung, 'name' => 'Es Teh Manis',         'qty' => 2],
                ],
            ],
            [
                'order' => [
                    'user_id' => $user2->id, 'driver_id' => $driver2->id, 'service_id' => $svcFood->id,
                    'status' => 'completed', 'price' => 45000,
                    'pickup_location' => 'Bakso Pak Kumis, Jl. Gatot Subroto No. 5',
                    'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
                    'notes' => null,
                ],
                'items' => [
                    ['store' => $storeBakso, 'name' => 'Mie Bakso Komplit', 'qty' => 1],
                    ['store' => $storeBakso, 'name' => 'Bakso Telur',        'qty' => 1],
                    ['store' => $storeBakso, 'name' => 'Es Teh',             'qty' => 2],
                ],
            ],
            [
                'order' => [
                    'user_id' => $user->id, 'driver_id' => $driver->id, 'service_id' => $svcFood->id,
                    'status' => 'completed', 'price' => 48000,
                    'pickup_location' => 'Ayam Geprek Bu Sri, Jl. Kebon Jeruk No. 20',
                    'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                    'notes' => 'Level 5 ya',
                ],
                'items' => [
                    ['store' => $storeGeprek, 'name' => 'Ayam Geprek Level 5', 'qty' => 2],
                    ['store' => $storeGeprek, 'name' => 'Es Jeruk',             'qty' => 2],
                ],
            ],
        ];

        foreach ($foodOrders as $fo) {
            $order = Order::create($fo['order']);
            foreach ($fo['items'] as $item) {
                $food = FoodItem::where('store_id', $item['store']->id)
                    ->where('name', $item['name'])->first();
                if ($food) {
                    FoodOrderItem::create([
                        'order_id'     => $order->id,
                        'food_item_id' => $food->id, // UUID food_item
                        'qty'          => $item['qty'],
                        'price'        => $food->price,
                    ]);
                }
            }
            $this->makePayment($order, 'success');
        }

        // ── Active orders (pending & accepted) ───────────────────────────
        // pending = belum ada driver
        $pending1 = Order::create([
            'user_id' => $user2->id, 'driver_id' => null, 'service_id' => $svcFood->id,
            'status' => 'pending', 'price' => 30000,
            'pickup_location' => 'Warung Siri, Jl. Sudirman No. 10',
            'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
            'notes' => 'Tambah sambal',
        ]);
        $food = FoodItem::where('store_id', $storeWarung->id)->where('name', 'Ayam Bakar Kecap')->first();
        if ($food) {
            FoodOrderItem::create([
                'order_id' => $pending1->id, 'food_item_id' => $food->id, 'qty' => 1, 'price' => $food->price,
            ]);
        }

        // accepted = driver sudah ambil, belum on_progress
        $accepted1 = Order::create([
            'user_id' => $user->id, 'driver_id' => $driver2->id, 'service_id' => $svcOjek->id,
            'status' => 'accepted', 'price' => 22000,
            'pickup_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
            'destination_location' => 'Jl. Senayan No. 1, Jakarta Selatan',
            'notes' => null,
        ]);
        $this->makePayment($accepted1, 'pending');

        // on_progress = driver sedang antar
        $onProgress = Order::create([
            'user_id' => $user->id, 'driver_id' => $driver->id, 'service_id' => $svcOjek->id,
            'status' => 'on_progress', 'price' => 20000,
            'pickup_location' => 'Jl. Kuningan No. 3, Jakarta Selatan',
            'destination_location' => 'Jl. HR Rasuna Said No. 10, Jakarta Selatan',
            'notes' => null,
        ]);
        $this->makePayment($onProgress, 'pending');

        // ── Cancelled orders ──────────────────────────────────────────────
        Order::create([
            'user_id' => $user->id, 'driver_id' => null, 'service_id' => $svcOjek->id,
            'status' => 'cancelled', 'price' => 15000,
            'pickup_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
            'destination_location' => 'Jl. Blok M No. 3, Jakarta Selatan',
            'notes' => null,
        ]);
        Order::create([
            'user_id' => $user2->id, 'driver_id' => null, 'service_id' => $svcFood->id,
            'status' => 'cancelled', 'price' => 25000,
            'pickup_location' => 'Bakso Pak Kumis, Jl. Gatot Subroto No. 5',
            'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
            'notes' => 'Batal karena driver tidak ada',
        ]);
    }

    private function makePayment(Order $order, string $status): void
    {
        Transaction::create([
            'user_id'   => $order->user_id,
            'order_id'  => $order->id,
            'amount'    => $order->price,
            'type'      => 'payment',
            'status'    => $status,
            'reference' => 'PAY-' . strtoupper(Str::random(10)),
        ]);
    }
}
