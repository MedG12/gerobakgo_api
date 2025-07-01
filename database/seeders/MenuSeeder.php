<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $menus = [
            // Menu untuk Merchant 1 (Warung Makan)
            [
                'merchant_id' => 1,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran',
                'price' => 25000,
            ],
            [
                'merchant_id' => 1,
                'name' => 'Mie Ayam Jamur',
                'description' => 'Mie ayam dengan jamur dan pangsit goreng',
                'price' => 20000,
            ],
            [
                'merchant_id' => 1,
                'name' => 'Es Teh Manis',
                'description' => 'Es teh dengan gula pasir',
                'price' => 5000,
            ],
            [
                'merchant_id' => 1,
                'name' => 'Ayam Goreng Kremes',
                'description' => 'Ayam goreng dengan kremes renyah',
                'price' => 30000,
            ],
            [
                'merchant_id' => 1,
                'name' => 'Sate Ayam',
                'description' => 'Sate ayam dengan bumbu kacang',
                'price' => 28000,
            ],

            // Menu untuk Merchant 2 (Kedai Kopi)
            [
                'merchant_id' => 2,
                'name' => 'Kopi Tubruk',
                'description' => 'Kopi tradisional diseduh dengan gula aren',
                'price' => 15000,
            ],
            [
                'merchant_id' => 2,
                'name' => 'Latte',
                'description' => 'Espresso dengan susu steamed',
                'price' => 25000,
            ],

            // Menu untuk Merchant 3 (Seafood)
            [
                'merchant_id' => 3,
                'name' => 'Gurame Bakar',
                'description' => 'Gurame segar dibakar dengan bumbu spesial',
                'price' => 75000,
            ],
            [
                'merchant_id' => 3,
                'name' => 'Cumi Saus Padang',
                'description' => 'Cumi segar dengan saus padang pedas',
                'price' => 65000,
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
