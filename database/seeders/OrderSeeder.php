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

        $serviceOjek     = Service::where('slug', 'ojek')->first();
        $serviceMobil    = Service::where('slug', 'car')->first();
        $serviceFood     = Service::where('slug', 'food')->first();
        $serviceDelivery = Service::where('slug', 'delivery')->first();

        $storeWarung  = Store::where('slug', 'warung-siri')->first();
        $storeBakso   = Store::where('slug', 'bakso-pak-kumis')->first();
        $storeGeprek  = Store::where('slug', 'ayam-geprek-bu-sri')->first();

        // ── Completed orders ──────────────────────────────────────────────
        $completedOrders = [
            [
                'user_id'              => $user->id,
                'driver_id'            => $driver->id,
                'service_id'           => $serviceOjek->id,
                'status'               => 'completed',
                'pickup_location'      => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'destination_location' => 'Jl. Gatot Subroto No. 20, Jakarta Selatan',
                'price'                => 25000,
                'notes'                => 'Tolong cepat ya',
            ],
            [
                'user_id'              => $user->id,
                'driver_id'            => $driver->id,
                'service_id'           => $serviceMobil->id,
                'status'               => 'completed',
                'pickup_location'      => 'Jl. Thamrin No. 1, Jakarta Pusat',
                'destination_location' => 'Bandara Soekarno-Hatta, Tangerang',
                'price'                => 150000,
                'notes'                => null,
            ],
            [
                'user_id'              => $user2->id,
                'driver_id'            => $driver2->id,
                'service_id'           => $serviceOjek->id,
                'status'               => 'completed',
                'pickup_location'      => 'Jl. Kebon Jeruk No. 10, Jakarta Barat',
                'destination_location' => 'Jl. Puri Indah No. 5, Jakarta Barat',
                'price'                => 18000,
                'notes'                => null,
            ],
            [
                'user_id'              => $user->id,
                'driver_id'            => $driver2->id,
                'service_id'           => $serviceDelivery->id,
                'status'               => 'completed',
                'pickup_location'      => 'Jl. Mangga Dua No. 3, Jakarta Utara',
                'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'price'                => 30000,
                'notes'                => 'Paket fragile, hati-hati',
            ],
        ];

        foreach ($completedOrders as $orderData) {
            $order = Order::create($orderData);
            $this->createTransaction($order, 'success');
        }

        // ── Food orders (completed) ───────────────────────────────────────
        $foodOrders = [
            [
                'order' => [
                    'user_id'              => $user->id,
                    'driver_id'            => $driver->id,
                    'service_id'           => $serviceFood->id,
                    'status'               => 'completed',
                    'pickup_location'      => 'Warung Siri, Jl. Sudirman No. 10',
                    'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                    'price'                => 57000,
                    'notes'                => 'Jangan lupa sendok',
                ],
                'store' => $storeWarung,
                'items' => [
                    ['name' => 'Nasi Goreng Spesial', 'qty' => 2],
                    ['name' => 'Es Teh Manis',         'qty' => 2],
                ],
            ],
            [
                'order' => [
                    'user_id'              => $user2->id,
                    'driver_id'            => $driver2->id,
                    'service_id'           => $serviceFood->id,
                    'status'               => 'completed',
                    'pickup_location'      => 'Bakso Pak Kumis, Jl. Gatot Subroto No. 5',
                    'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
                    'price'                => 45000,
                    'notes'                => null,
                ],
                'store' => $storeBakso,
                'items' => [
                    ['name' => 'Mie Bakso Komplit', 'qty' => 1],
                    ['name' => 'Bakso Telur',        'qty' => 1],
                    ['name' => 'Es Teh',             'qty' => 2],
                ],
            ],
            [
                'order' => [
                    'user_id'              => $user->id,
                    'driver_id'            => $driver->id,
                    'service_id'           => $serviceFood->id,
                    'status'               => 'completed',
                    'pickup_location'      => 'Ayam Geprek Bu Sri, Jl. Kebon Jeruk No. 20',
                    'destination_location' => 'Jl. Sudirman No. 5, Jakarta Pusat',
                    'price'                => 48000,
                    'notes'                => 'Level 5 ya',
                ],
                'store' => $storeGeprek,
                'items' => [
                    ['name' => 'Ayam Geprek Level 5', 'qty' => 2],
                    ['name' => 'Es Jeruk',             'qty' => 2],
                ],
            ],
        ];

        foreach ($foodOrders as $fo) {
            $order = Order::create($fo['order']);
            foreach ($fo['items'] as $item) {
                $foodItem = FoodItem::where('store_id', $fo['store']->id)
                    ->where('name', $item['name'])->first();
                if ($foodItem) {
                    FoodOrderItem::create([
                        'order_id'     => $order->id,
                        'food_item_id' => $foodItem->id,
                        'qty'          => $item['qty'],
                        'price'        => $foodItem->price,
                    ]);
                }
            }
            $this->createTransaction($order, 'success');
        }

        // ── Active / in-progress orders ───────────────────────────────────
        $activeOrders = [
            [
                'user_id'              => $user->id,
                'driver_id'            => $driver->id,
                'service_id'           => $serviceOjek->id,
                'status'               => 'on_progress',
                'pickup_location'      => 'Jl. Kuningan No. 3, Jakarta Selatan',
                'destination_location' => 'Jl. HR Rasuna Said No. 10, Jakarta Selatan',
                'price'                => 20000,
                'notes'                => null,
            ],
            [
                'user_id'              => $user2->id,
                'driver_id'            => null,
                'service_id'           => $serviceFood->id,
                'status'               => 'pending',
                'pickup_location'      => 'Warung Siri, Jl. Sudirman No. 10',
                'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
                'price'                => 30000,
                'notes'                => 'Tambah sambal',
            ],
            [
                'user_id'              => $user->id,
                'driver_id'            => $driver2->id,
                'service_id'           => $serviceOjek->id,
                'status'               => 'accepted',
                'pickup_location'      => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'destination_location' => 'Jl. Senayan No. 1, Jakarta Selatan',
                'price'                => 22000,
                'notes'                => null,
            ],
        ];

        foreach ($activeOrders as $orderData) {
            $order = Order::create($orderData);
            if ($order->status !== 'pending') {
                $this->createTransaction($order, 'pending');
            }
        }

        // ── Cancelled orders ──────────────────────────────────────────────
        $cancelledOrders = [
            [
                'user_id'              => $user->id,
                'driver_id'            => null,
                'service_id'           => $serviceOjek->id,
                'status'               => 'cancelled',
                'pickup_location'      => 'Jl. Sudirman No. 5, Jakarta Pusat',
                'destination_location' => 'Jl. Blok M No. 3, Jakarta Selatan',
                'price'                => 15000,
                'notes'                => null,
            ],
            [
                'user_id'              => $user2->id,
                'driver_id'            => null,
                'service_id'           => $serviceFood->id,
                'status'               => 'cancelled',
                'pickup_location'      => 'Bakso Pak Kumis, Jl. Gatot Subroto No. 5',
                'destination_location' => 'Jl. Thamrin No. 10, Jakarta Pusat',
                'price'                => 25000,
                'notes'                => 'Batal karena driver tidak ada',
            ],
        ];

        foreach ($cancelledOrders as $orderData) {
            Order::create($orderData);
        }

        // ── Topup transactions ────────────────────────────────────────────
        $topups = [
            ['user_id' => $user->id,  'amount' => 200000],
            ['user_id' => $user->id,  'amount' => 500000],
            ['user_id' => $user2->id, 'amount' => 100000],
            ['user_id' => $user2->id, 'amount' => 300000],
        ];

        foreach ($topups as $topup) {
            Transaction::create([
                'user_id'   => $topup['user_id'],
                'order_id'  => null,
                'amount'    => $topup['amount'],
                'type'      => 'topup',
                'status'    => 'success',
                'reference' => 'TOPUP-' . strtoupper(Str::random(10)),
            ]);
        }
    }

    private function createTransaction(Order $order, string $status): void
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
