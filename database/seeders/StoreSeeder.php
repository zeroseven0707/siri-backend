<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::where('email', 'user@siri.id')->first();

        $stores = [
            [
                'slug' => 'warung-siri',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Warung Siri', 'is_open' => true, 'is_active' => true,
                    'description' => 'Masakan rumahan enak dan murah',
                    'address' => 'Jl. Sudirman No. 10, Jakarta Pusat',
                    'latitude' => -6.2088, 'longitude' => 106.8456,
                ],
                'foods' => [
                    ['name' => 'Nasi Goreng Spesial',    'price' => 25000, 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran'],
                    ['name' => 'Nasi Goreng Seafood',    'price' => 30000, 'description' => 'Nasi goreng dengan udang dan cumi'],
                    ['name' => 'Mie Ayam Bakso',         'price' => 20000, 'description' => 'Mie ayam dengan bakso sapi'],
                    ['name' => 'Mie Goreng Spesial',     'price' => 22000, 'description' => 'Mie goreng dengan telur dan sayuran'],
                    ['name' => 'Ayam Bakar Kecap',       'price' => 35000, 'description' => 'Ayam bakar bumbu kecap manis'],
                    ['name' => 'Ayam Goreng Kremes',     'price' => 32000, 'description' => 'Ayam goreng dengan kremes renyah'],
                    ['name' => 'Gado-Gado',              'price' => 18000, 'description' => 'Gado-gado sayur segar dengan bumbu kacang'],
                    ['name' => 'Soto Ayam',              'price' => 20000, 'description' => 'Soto ayam kuah bening dengan nasi'],
                    ['name' => 'Rawon',                  'price' => 28000, 'description' => 'Rawon daging sapi kuah hitam'],
                    ['name' => 'Es Teh Manis',           'price' => 5000,  'description' => 'Es teh manis segar'],
                    ['name' => 'Es Jeruk',               'price' => 7000,  'description' => 'Es jeruk peras segar'],
                    ['name' => 'Jus Alpukat',            'price' => 12000, 'description' => 'Jus alpukat segar dengan susu'],
                ],
            ],
            [
                'slug' => 'bakso-pak-kumis',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Bakso Pak Kumis', 'is_open' => true, 'is_active' => true,
                    'description' => 'Bakso sapi asli dengan kuah kaldu spesial',
                    'address' => 'Jl. Gatot Subroto No. 5, Jakarta Selatan',
                    'latitude' => -6.2297, 'longitude' => 106.8295,
                ],
                'foods' => [
                    ['name' => 'Bakso Biasa',            'price' => 15000, 'description' => 'Bakso sapi dengan kuah kaldu'],
                    ['name' => 'Bakso Urat',             'price' => 18000, 'description' => 'Bakso urat sapi kenyal'],
                    ['name' => 'Bakso Telur',            'price' => 20000, 'description' => 'Bakso besar isi telur'],
                    ['name' => 'Bakso Bakar',            'price' => 22000, 'description' => 'Bakso dibakar dengan bumbu kecap'],
                    ['name' => 'Mie Bakso Komplit',      'price' => 25000, 'description' => 'Mie, bakso, tahu, dan pangsit'],
                    ['name' => 'Bihun Bakso',            'price' => 22000, 'description' => 'Bihun dengan bakso dan kuah kaldu'],
                    ['name' => 'Pangsit Goreng',         'price' => 10000, 'description' => 'Pangsit goreng renyah isi daging'],
                    ['name' => 'Tahu Goreng',            'price' => 8000,  'description' => 'Tahu goreng crispy'],
                    ['name' => 'Es Teh',                 'price' => 5000,  'description' => 'Es teh manis'],
                    ['name' => 'Air Mineral',            'price' => 4000,  'description' => 'Air mineral botol'],
                ],
            ],
            [
                'slug' => 'ayam-geprek-bu-sri',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Ayam Geprek Bu Sri', 'is_open' => true, 'is_active' => true,
                    'description' => 'Ayam geprek sambal bawang level 1-10',
                    'address' => 'Jl. Kebon Jeruk No. 20, Jakarta Barat',
                    'latitude' => -6.1944, 'longitude' => 106.7829,
                ],
                'foods' => [
                    ['name' => 'Ayam Geprek Level 1',    'price' => 18000, 'description' => 'Ayam geprek sambal bawang level 1'],
                    ['name' => 'Ayam Geprek Level 3',    'price' => 18000, 'description' => 'Ayam geprek sambal bawang level 3'],
                    ['name' => 'Ayam Geprek Level 5',    'price' => 18000, 'description' => 'Ayam geprek sambal bawang level 5'],
                    ['name' => 'Ayam Geprek Level 10',   'price' => 20000, 'description' => 'Ayam geprek sambal bawang level 10 super pedas'],
                    ['name' => 'Ayam Geprek Keju',       'price' => 25000, 'description' => 'Ayam geprek dengan lelehan keju'],
                    ['name' => 'Ayam Geprek Mozarella',  'price' => 28000, 'description' => 'Ayam geprek dengan mozarella'],
                    ['name' => 'Nasi Putih',             'price' => 4000,  'description' => 'Nasi putih pulen'],
                    ['name' => 'Tempe Goreng',           'price' => 5000,  'description' => 'Tempe goreng crispy'],
                    ['name' => 'Tahu Goreng',            'price' => 5000,  'description' => 'Tahu goreng crispy'],
                    ['name' => 'Es Teh Manis',           'price' => 5000,  'description' => 'Es teh manis segar'],
                    ['name' => 'Es Jeruk',               'price' => 7000,  'description' => 'Es jeruk peras'],
                    ['name' => 'Jus Mangga',             'price' => 12000, 'description' => 'Jus mangga segar'],
                ],
            ],
            [
                'slug' => 'pizza-corner',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Pizza Corner', 'is_open' => true, 'is_active' => true,
                    'description' => 'Pizza homemade dengan topping melimpah',
                    'address' => 'Jl. Thamrin No. 15, Jakarta Pusat',
                    'latitude' => -6.1944, 'longitude' => 106.8229,
                ],
                'foods' => [
                    ['name' => 'Pizza Margherita',       'price' => 55000, 'description' => 'Pizza klasik dengan saus tomat dan mozzarella'],
                    ['name' => 'Pizza Pepperoni',        'price' => 65000, 'description' => 'Pizza dengan pepperoni dan keju'],
                    ['name' => 'Pizza BBQ Chicken',      'price' => 70000, 'description' => 'Pizza ayam BBQ dengan saus BBQ'],
                    ['name' => 'Pizza Seafood',          'price' => 75000, 'description' => 'Pizza dengan udang, cumi, dan kerang'],
                    ['name' => 'Pizza Vegetarian',       'price' => 60000, 'description' => 'Pizza dengan sayuran segar'],
                    ['name' => 'Pasta Carbonara',        'price' => 45000, 'description' => 'Pasta carbonara creamy'],
                    ['name' => 'Pasta Bolognese',        'price' => 45000, 'description' => 'Pasta dengan saus daging bolognese'],
                    ['name' => 'Garlic Bread',           'price' => 20000, 'description' => 'Roti bawang putih dengan butter'],
                    ['name' => 'French Fries',           'price' => 18000, 'description' => 'Kentang goreng crispy'],
                    ['name' => 'Chicken Wings',          'price' => 35000, 'description' => 'Sayap ayam goreng bumbu spesial'],
                    ['name' => 'Soft Drink',             'price' => 10000, 'description' => 'Minuman bersoda pilihan'],
                    ['name' => 'Milkshake Coklat',       'price' => 22000, 'description' => 'Milkshake coklat creamy'],
                ],
            ],
            [
                'slug' => 'sate-madura-pak-haji',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Sate Madura Pak Haji', 'is_open' => true, 'is_active' => true,
                    'description' => 'Sate madura asli dengan bumbu kacang spesial',
                    'address' => 'Jl. Mangga Besar No. 8, Jakarta Barat',
                    'latitude' => -6.1500, 'longitude' => 106.8200,
                ],
                'foods' => [
                    ['name' => 'Sate Ayam 10 Tusuk',     'price' => 20000, 'description' => 'Sate ayam 10 tusuk dengan bumbu kacang'],
                    ['name' => 'Sate Kambing 10 Tusuk',  'price' => 30000, 'description' => 'Sate kambing 10 tusuk dengan kecap'],
                    ['name' => 'Sate Ayam 20 Tusuk',     'price' => 38000, 'description' => 'Sate ayam 20 tusuk dengan bumbu kacang'],
                    ['name' => 'Sate Kambing 20 Tusuk',  'price' => 58000, 'description' => 'Sate kambing 20 tusuk dengan kecap'],
                    ['name' => 'Lontong',                'price' => 5000,  'description' => 'Lontong nasi'],
                    ['name' => 'Nasi Putih',             'price' => 4000,  'description' => 'Nasi putih'],
                    ['name' => 'Soto Madura',            'price' => 22000, 'description' => 'Soto madura daging sapi'],
                    ['name' => 'Gulai Kambing',          'price' => 35000, 'description' => 'Gulai kambing kuah santan'],
                    ['name' => 'Es Teh',                 'price' => 5000,  'description' => 'Es teh manis'],
                    ['name' => 'Es Kelapa Muda',         'price' => 12000, 'description' => 'Es kelapa muda segar'],
                ],
            ],
            [
                'slug' => 'kopi-nusantara',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Kopi Nusantara', 'is_open' => true, 'is_active' => true,
                    'description' => 'Kopi pilihan dari seluruh nusantara',
                    'address' => 'Jl. Kemang Raya No. 30, Jakarta Selatan',
                    'latitude' => -6.2600, 'longitude' => 106.8150,
                ],
                'foods' => [
                    ['name' => 'Kopi Hitam',             'price' => 12000, 'description' => 'Kopi hitam tubruk'],
                    ['name' => 'Kopi Susu',              'price' => 15000, 'description' => 'Kopi susu manis'],
                    ['name' => 'Kopi Latte',             'price' => 22000, 'description' => 'Espresso dengan susu steamed'],
                    ['name' => 'Cappuccino',             'price' => 22000, 'description' => 'Espresso dengan foam susu'],
                    ['name' => 'Americano',              'price' => 18000, 'description' => 'Espresso dengan air panas'],
                    ['name' => 'Kopi Aceh',              'price' => 18000, 'description' => 'Kopi Aceh gayo spesial'],
                    ['name' => 'Kopi Toraja',            'price' => 20000, 'description' => 'Kopi Toraja arabika'],
                    ['name' => 'Matcha Latte',           'price' => 25000, 'description' => 'Matcha latte dengan susu'],
                    ['name' => 'Teh Tarik',              'price' => 15000, 'description' => 'Teh tarik khas Malaysia'],
                    ['name' => 'Croissant',              'price' => 18000, 'description' => 'Croissant butter'],
                    ['name' => 'Roti Bakar Coklat',      'price' => 15000, 'description' => 'Roti bakar dengan selai coklat'],
                    ['name' => 'Sandwich Ayam',          'price' => 28000, 'description' => 'Sandwich ayam panggang'],
                ],
            ],
            [
                'slug' => 'padang-minang-jaya',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Padang Minang Jaya', 'is_open' => true, 'is_active' => true,
                    'description' => 'Masakan Padang asli dengan rendang spesial',
                    'address' => 'Jl. Fatmawati No. 12, Jakarta Selatan',
                    'latitude' => -6.2900, 'longitude' => 106.7950,
                ],
                'foods' => [
                    ['name' => 'Nasi Rendang',           'price' => 35000, 'description' => 'Nasi dengan rendang daging sapi'],
                    ['name' => 'Nasi Ayam Pop',          'price' => 28000, 'description' => 'Nasi dengan ayam pop khas Padang'],
                    ['name' => 'Nasi Gulai Ikan',        'price' => 30000, 'description' => 'Nasi dengan gulai ikan'],
                    ['name' => 'Nasi Dendeng Balado',    'price' => 35000, 'description' => 'Nasi dengan dendeng balado pedas'],
                    ['name' => 'Nasi Padang Komplit',    'price' => 45000, 'description' => 'Nasi padang dengan lauk lengkap'],
                    ['name' => 'Gulai Otak',             'price' => 20000, 'description' => 'Gulai otak sapi'],
                    ['name' => 'Perkedel',               'price' => 5000,  'description' => 'Perkedel kentang goreng'],
                    ['name' => 'Sambal Ijo',             'price' => 5000,  'description' => 'Sambal ijo khas Padang'],
                    ['name' => 'Es Teh Tawar',           'price' => 4000,  'description' => 'Es teh tawar'],
                    ['name' => 'Air Mineral',            'price' => 4000,  'description' => 'Air mineral'],
                ],
            ],
            [
                'slug' => 'burger-smash',
                'data' => [
                    'user_id' => $owner->id, 'name' => 'Burger Smash', 'is_open' => false, 'is_active' => true,
                    'description' => 'Smash burger juicy dengan daging sapi lokal',
                    'address' => 'Jl. Senopati No. 7, Jakarta Selatan',
                    'latitude' => -6.2350, 'longitude' => 106.8100,
                ],
                'foods' => [
                    ['name' => 'Single Smash Burger',    'price' => 35000, 'description' => 'Burger dengan 1 patty daging sapi'],
                    ['name' => 'Double Smash Burger',    'price' => 50000, 'description' => 'Burger dengan 2 patty daging sapi'],
                    ['name' => 'Cheese Burger',          'price' => 40000, 'description' => 'Burger dengan keju cheddar'],
                    ['name' => 'Mushroom Burger',        'price' => 45000, 'description' => 'Burger dengan jamur sauteed'],
                    ['name' => 'Chicken Burger',         'price' => 32000, 'description' => 'Burger ayam crispy'],
                    ['name' => 'French Fries',           'price' => 18000, 'description' => 'Kentang goreng crispy'],
                    ['name' => 'Onion Rings',            'price' => 20000, 'description' => 'Bawang bombay goreng crispy'],
                    ['name' => 'Milkshake Vanilla',      'price' => 22000, 'description' => 'Milkshake vanilla creamy'],
                    ['name' => 'Milkshake Strawberry',   'price' => 22000, 'description' => 'Milkshake strawberry segar'],
                    ['name' => 'Soft Drink',             'price' => 10000, 'description' => 'Minuman bersoda pilihan'],
                ],
            ],
        ];

        foreach ($stores as $storeData) {
            $store = Store::firstOrCreate(['slug' => $storeData['slug']], $storeData['data']);
            foreach ($storeData['foods'] as $food) {
                FoodItem::firstOrCreate(
                    ['store_id' => $store->id, 'name' => $food['name']],
                    array_merge($food, ['is_available' => true])
                );
            }
        }
    }
}
