<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use App\Models\HomeSectionItem;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section' => [
                    'title' => 'Banner Promo', 'key' => 'banner_promo',
                    'type' => 'banner', 'order' => 1, 'is_active' => true,
                ],
                'items' => [
                    [
                        'title' => 'Promo Ramadan 50%', 'subtitle' => 'Diskon 50% untuk semua menu pilihan',
                        'image' => 'https://placehold.co/800x300/FF6B35/white?text=Promo+Ramadan',
                        'action_type' => 'url', 'action_value' => 'https://siri.id/promo', 'order' => 1, 'is_active' => true,
                    ],
                    [
                        'title' => 'Gratis Ongkir', 'subtitle' => 'Gratis ongkir untuk order pertama',
                        'image' => 'https://placehold.co/800x300/4CAF50/white?text=Gratis+Ongkir',
                        'action_type' => 'url', 'action_value' => 'https://siri.id/gratis-ongkir', 'order' => 2, 'is_active' => true,
                    ],
                    [
                        'title' => 'Cashback 20%', 'subtitle' => 'Cashback 20% dengan SiriPay',
                        'image' => 'https://placehold.co/800x300/2196F3/white?text=Cashback+20%25',
                        'action_type' => 'url', 'action_value' => 'https://siri.id/cashback', 'order' => 3, 'is_active' => true,
                    ],
                ],
            ],
            [
                'section' => [
                    'title' => 'Layanan Kami', 'key' => 'services',
                    'type' => 'service_list', 'order' => 2, 'is_active' => true,
                ],
                'items' => [
                    [
                        'title' => 'Pesan Makanan', 'subtitle' => 'Pesan makanan favoritmu',
                        'image' => 'https://placehold.co/100x100/FF6B35/white?text=Food',
                        'action_type' => 'route', 'action_value' => 'food', 'order' => 1, 'is_active' => true,
                    ],
                    [
                        'title' => 'Ojek', 'subtitle' => 'Antar jemput cepat',
                        'image' => 'https://placehold.co/100x100/4CAF50/white?text=Ojek',
                        'action_type' => 'route', 'action_value' => 'ojek', 'order' => 2, 'is_active' => true,
                    ],
                    [
                        'title' => 'Mobil', 'subtitle' => 'Perjalanan nyaman',
                        'image' => 'https://placehold.co/100x100/2196F3/white?text=Mobil',
                        'action_type' => 'route', 'action_value' => 'car', 'order' => 3, 'is_active' => true,
                    ],
                    [
                        'title' => 'Kirim Paket', 'subtitle' => 'Kirim barang aman',
                        'image' => 'https://placehold.co/100x100/9C27B0/white?text=Paket',
                        'action_type' => 'route', 'action_value' => 'delivery', 'order' => 4, 'is_active' => true,
                    ],
                ],
            ],
            [
                'section' => [
                    'title' => 'Restoran Populer', 'key' => 'popular_stores',
                    'type' => 'store_list', 'order' => 3, 'is_active' => true,
                ],
                'items' => [
                    [
                        'title' => 'Warung Siri', 'subtitle' => 'Masakan rumahan enak',
                        'image' => 'https://placehold.co/300x200/FF6B35/white?text=Warung+Siri',
                        'action_type' => 'store', 'action_value' => 'warung-siri', 'order' => 1, 'is_active' => true,
                    ],
                    [
                        'title' => 'Bakso Pak Kumis', 'subtitle' => 'Bakso sapi asli',
                        'image' => 'https://placehold.co/300x200/4CAF50/white?text=Bakso+Pak+Kumis',
                        'action_type' => 'store', 'action_value' => 'bakso-pak-kumis', 'order' => 2, 'is_active' => true,
                    ],
                    [
                        'title' => 'Ayam Geprek Bu Sri', 'subtitle' => 'Geprek level 1-10',
                        'image' => 'https://placehold.co/300x200/F44336/white?text=Ayam+Geprek',
                        'action_type' => 'store', 'action_value' => 'ayam-geprek-bu-sri', 'order' => 3, 'is_active' => true,
                    ],
                    [
                        'title' => 'Kopi Nusantara', 'subtitle' => 'Kopi pilihan nusantara',
                        'image' => 'https://placehold.co/300x200/795548/white?text=Kopi+Nusantara',
                        'action_type' => 'store', 'action_value' => 'kopi-nusantara', 'order' => 4, 'is_active' => true,
                    ],
                ],
            ],
            [
                'section' => [
                    'title' => 'Menu Favorit', 'key' => 'popular_foods',
                    'type' => 'food_list', 'order' => 4, 'is_active' => true,
                ],
                'items' => [
                    [
                        'title' => 'Nasi Goreng Spesial', 'subtitle' => 'Rp 25.000',
                        'image' => 'https://placehold.co/200x200/FF6B35/white?text=Nasi+Goreng',
                        'action_type' => 'food', 'action_value' => 'nasi-goreng-spesial', 'order' => 1, 'is_active' => true,
                    ],
                    [
                        'title' => 'Ayam Geprek', 'subtitle' => 'Rp 18.000',
                        'image' => 'https://placehold.co/200x200/F44336/white?text=Ayam+Geprek',
                        'action_type' => 'food', 'action_value' => 'ayam-geprek', 'order' => 2, 'is_active' => true,
                    ],
                    [
                        'title' => 'Bakso Komplit', 'subtitle' => 'Rp 25.000',
                        'image' => 'https://placehold.co/200x200/4CAF50/white?text=Bakso',
                        'action_type' => 'food', 'action_value' => 'bakso-komplit', 'order' => 3, 'is_active' => true,
                    ],
                    [
                        'title' => 'Pizza Margherita', 'subtitle' => 'Rp 55.000',
                        'image' => 'https://placehold.co/200x200/FF9800/white?text=Pizza',
                        'action_type' => 'food', 'action_value' => 'pizza-margherita', 'order' => 4, 'is_active' => true,
                    ],
                    [
                        'title' => 'Rendang', 'subtitle' => 'Rp 35.000',
                        'image' => 'https://placehold.co/200x200/795548/white?text=Rendang',
                        'action_type' => 'food', 'action_value' => 'rendang', 'order' => 5, 'is_active' => true,
                    ],
                ],
            ],
            [
                'section' => [
                    'title' => 'Promo Spesial', 'key' => 'promo_special',
                    'type' => 'promo', 'order' => 5, 'is_active' => true,
                ],
                'items' => [
                    [
                        'title' => 'Hemat Bareng Teman', 'subtitle' => 'Order 2 porsi diskon 15%',
                        'image' => 'https://placehold.co/400x200/E91E63/white?text=Hemat+Bareng',
                        'action_type' => 'url', 'action_value' => 'https://siri.id/promo/hemat-bareng', 'order' => 1, 'is_active' => true,
                    ],
                    [
                        'title' => 'Happy Hour', 'subtitle' => 'Diskon 25% jam 14.00-16.00',
                        'image' => 'https://placehold.co/400x200/FF5722/white?text=Happy+Hour',
                        'action_type' => 'url', 'action_value' => 'https://siri.id/promo/happy-hour', 'order' => 2, 'is_active' => true,
                    ],
                ],
            ],
        ];

        foreach ($sections as $s) {
            $section = HomeSection::firstOrCreate(['key' => $s['section']['key']], $s['section']);
            foreach ($s['items'] as $item) {
                HomeSectionItem::firstOrCreate(
                    ['home_section_id' => $section->id, 'title' => $item['title']],
                    $item
                );
            }
        }
    }
}
