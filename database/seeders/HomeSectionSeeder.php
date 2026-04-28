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
        // action_value pakai slug service, action_type = 'service'
        // Items are managed via admin panel, not seeded
        $serviceSection = HomeSection::firstOrCreate(['key' => 'services'], [
            'title' => 'Layanan Kami', 'type' => 'service_list', 'order' => 2, 'is_active' => true,
        ]);
        // Note: Service items should be created via admin panel to avoid duplicates

        // ── Store List ────────────────────────────────────────────────────
        // action_value pakai UUID store, action_type = 'store'
        $storeSection = HomeSection::firstOrCreate(['key' => 'popular_stores'], [
            'title' => 'Restoran Populer', 'type' => 'store_list', 'order' => 3, 'is_active' => true,
        ]);
        $storeItems = [];
        foreach ([
            ['slug' => 'warung-siri',         'order' => 1],
            ['slug' => 'bakso-pak-kumis',      'order' => 2],
            ['slug' => 'ayam-geprek-bu-sri',   'order' => 3],
            ['slug' => 'kopi-nusantara',       'order' => 4],
            ['slug' => 'padang-minang-jaya',   'order' => 5],
        ] as $s) {
            $store = Store::where('slug', $s['slug'])->first();
            if ($store) {
                $storeItems[] = [
                    'title'        => $store->name,
                    'subtitle'     => $store->description,
                    'image'        => $store->image, // Use actual store image
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
            ['store_slug' => 'warung-siri',       'name' => 'Nasi Goreng Spesial',  'order' => 1],
            ['store_slug' => 'ayam-geprek-bu-sri', 'name' => 'Ayam Geprek Level 5', 'order' => 2],
            ['store_slug' => 'bakso-pak-kumis',    'name' => 'Mie Bakso Komplit',   'order' => 3],
            ['store_slug' => 'pizza-corner',       'name' => 'Pizza Margherita',    'order' => 4],
            ['store_slug' => 'padang-minang-jaya', 'name' => 'Nasi Rendang',        'order' => 5],
        ];
        foreach ($popularFoods as $pf) {
            $store = Store::where('slug', $pf['store_slug'])->first();
            if (!$store) continue;
            $food = FoodItem::where('store_id', $store->id)->where('name', $pf['name'])->first();
            if ($food) {
                $foodItems[] = [
                    'title'        => $food->name,
                    'subtitle'     => 'Rp ' . number_format($food->price, 0, ',', '.'),
                    'image'        => $food->image, // Use actual food image
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
            HomeSectionItem::updateOrCreate(
                ['home_section_id' => $section->id, 'title' => $item['title']],
                $item
            );
        }
    }
}
