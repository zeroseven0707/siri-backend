<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\HomeSection;
use App\Models\HomeSectionItem;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        // ── Banner Promo ──────────────────────────────────────────────────
        $banner = HomeSection::firstOrCreate(['key' => 'banner_promo'], [
            'title' => 'Banner Promo', 'type' => 'banner', 'order' => 1, 'is_active' => true,
        ]);
        $this->seedItems($banner, [
            [
                'title' => 'Promo Ramadan 50%', 'subtitle' => 'Diskon 50% untuk semua menu pilihan',
                'image' => 'https://placehold.co/800x300/FF6B35/white?text=Promo+Ramadan',
                'action_type' => 'url', 'action_value' => 'https://siri.id/promo',
                'order' => 1, 'is_active' => true,
            ],
            [
                'title' => 'Gratis Ongkir', 'subtitle' => 'Gratis ongkir untuk order pertama',
                'image' => 'https://placehold.co/800x300/4CAF50/white?text=Gratis+Ongkir',
                'action_type' => 'url', 'action_value' => 'https://siri.id/gratis-ongkir',
                'order' => 2, 'is_active' => true,
            ],
            [
                'title' => 'Cashback 20%', 'subtitle' => 'Cashback 20% dengan SiriPay',
                'image' => 'https://placehold.co/800x300/2196F3/white?text=Cashback+20%25',
                'action_type' => 'url', 'action_value' => 'https://siri.id/cashback',
                'order' => 3, 'is_active' => true,
            ],
        ]);

        // ── Service List ──────────────────────────────────────────────────
        // action_value pakai UUID service, action_type = 'service'
        $serviceSection = HomeSection::firstOrCreate(['key' => 'services'], [
            'title' => 'Layanan Kami', 'type' => 'service_list', 'order' => 2, 'is_active' => true,
        ]);
        $services = Service::all()->keyBy('slug');
        $serviceItems = [];
        foreach ([
            ['slug' => 'food',     'title' => 'Pesan Makanan', 'subtitle' => 'Pesan makanan favoritmu',  'image' => 'https://placehold.co/100x100/FF6B35/white?text=Food',   'order' => 1],
            ['slug' => 'ojek',     'title' => 'Ojek',          'subtitle' => 'Antar jemput cepat',       'image' => 'https://placehold.co/100x100/4CAF50/white?text=Ojek',   'order' => 2],
            ['slug' => 'car',      'title' => 'Mobil',         'subtitle' => 'Perjalanan nyaman',        'image' => 'https://placehold.co/100x100/2196F3/white?text=Mobil',  'order' => 3],
            ['slug' => 'delivery', 'title' => 'Kirim Paket',   'subtitle' => 'Kirim barang aman',        'image' => 'https://placehold.co/100x100/9C27B0/white?text=Paket',  'order' => 4],
        ] as $s) {
            if (isset($services[$s['slug']])) {
                $serviceItems[] = [
                    'title'        => $s['title'],
                    'subtitle'     => $s['subtitle'],
                    'image'        => $s['image'],
                    'action_type'  => 'service',
                    'action_value' => $services[$s['slug']]->id, // UUID service
                    'order'        => $s['order'],
                    'is_active'    => true,
                ];
            }
        }
        $this->seedItems($serviceSection, $serviceItems);

        // ── Store List ────────────────────────────────────────────────────
        // action_value pakai UUID store, action_type = 'store'
        $storeSection = HomeSection::firstOrCreate(['key' => 'popular_stores'], [
            'title' => 'Restoran Populer', 'type' => 'store_list', 'order' => 3, 'is_active' => true,
        ]);
        $storeItems = [];
        foreach ([
            ['slug' => 'warung-siri',         'image' => 'https://placehold.co/300x200/FF6B35/white?text=Warung+Siri',      'order' => 1],
            ['slug' => 'bakso-pak-kumis',      'image' => 'https://placehold.co/300x200/4CAF50/white?text=Bakso+Pak+Kumis', 'order' => 2],
            ['slug' => 'ayam-geprek-bu-sri',   'image' => 'https://placehold.co/300x200/F44336/white?text=Ayam+Geprek',     'order' => 3],
            ['slug' => 'kopi-nusantara',       'image' => 'https://placehold.co/300x200/795548/white?text=Kopi+Nusantara',  'order' => 4],
            ['slug' => 'padang-minang-jaya',   'image' => 'https://placehold.co/300x200/FF9800/white?text=Padang+Minang',   'order' => 5],
        ] as $s) {
            $store = Store::where('slug', $s['slug'])->first();
            if ($store) {
                $storeItems[] = [
                    'title'        => $store->name,
                    'subtitle'     => $store->description,
                    'image'        => $s['image'],
                    'action_type'  => 'store',
                    'action_value' => $store->id, // UUID store
                    'order'        => $s['order'],
                    'is_active'    => true,
                ];
            }
        }
        $this->seedItems($storeSection, $storeItems);

        // ── Food List ─────────────────────────────────────────────────────
        // action_value pakai UUID food_item, action_type = 'food'
        $foodSection = HomeSection::firstOrCreate(['key' => 'popular_foods'], [
            'title' => 'Menu Favorit', 'type' => 'food_list', 'order' => 4, 'is_active' => true,
        ]);
        $foodItems = [];
        $popularFoods = [
            ['store_slug' => 'warung-siri',       'name' => 'Nasi Goreng Spesial',  'image' => 'https://placehold.co/200x200/FF6B35/white?text=Nasi+Goreng', 'order' => 1],
            ['store_slug' => 'ayam-geprek-bu-sri', 'name' => 'Ayam Geprek Level 5', 'image' => 'https://placehold.co/200x200/F44336/white?text=Ayam+Geprek', 'order' => 2],
            ['store_slug' => 'bakso-pak-kumis',    'name' => 'Mie Bakso Komplit',   'image' => 'https://placehold.co/200x200/4CAF50/white?text=Bakso',        'order' => 3],
            ['store_slug' => 'pizza-corner',       'name' => 'Pizza Margherita',    'image' => 'https://placehold.co/200x200/FF9800/white?text=Pizza',         'order' => 4],
            ['store_slug' => 'padang-minang-jaya', 'name' => 'Nasi Rendang',        'image' => 'https://placehold.co/200x200/795548/white?text=Rendang',       'order' => 5],
        ];
        foreach ($popularFoods as $pf) {
            $store = Store::where('slug', $pf['store_slug'])->first();
            if (!$store) continue;
            $food = FoodItem::where('store_id', $store->id)->where('name', $pf['name'])->first();
            if ($food) {
                $foodItems[] = [
                    'title'        => $food->name,
                    'subtitle'     => 'Rp ' . number_format($food->price, 0, ',', '.'),
                    'image'        => $pf['image'],
                    'action_type'  => 'food',
                    'action_value' => $food->id, // UUID food_item
                    'order'        => $pf['order'],
                    'is_active'    => true,
                ];
            }
        }
        $this->seedItems($foodSection, $foodItems);

        // ── Promo Spesial ─────────────────────────────────────────────────
        $promo = HomeSection::firstOrCreate(['key' => 'promo_special'], [
            'title' => 'Promo Spesial', 'type' => 'promo', 'order' => 5, 'is_active' => true,
        ]);
        $this->seedItems($promo, [
            [
                'title' => 'Hemat Bareng Teman', 'subtitle' => 'Order 2 porsi diskon 15%',
                'image' => 'https://placehold.co/400x200/E91E63/white?text=Hemat+Bareng',
                'action_type' => 'url', 'action_value' => 'https://siri.id/promo/hemat-bareng',
                'order' => 1, 'is_active' => true,
            ],
            [
                'title' => 'Happy Hour', 'subtitle' => 'Diskon 25% jam 14.00-16.00',
                'image' => 'https://placehold.co/400x200/FF5722/white?text=Happy+Hour',
                'action_type' => 'url', 'action_value' => 'https://siri.id/promo/happy-hour',
                'order' => 2, 'is_active' => true,
            ],
        ]);
    }

    private function seedItems(HomeSection $section, array $items): void
    {
        foreach ($items as $item) {
            HomeSectionItem::firstOrCreate(
                ['home_section_id' => $section->id, 'title' => $item['title']],
                $item
            );
        }
    }
}
