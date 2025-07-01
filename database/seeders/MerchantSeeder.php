<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Merchant;
use App\Models\User;
use Carbon\Carbon;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // First, ensure the user exists


        $merchants = [
            [
                'user_id' => '1',
                'description' => 'Warung Makan Sederhana menyajikan makanan rumahan dengan cita rasa tradisional',
                'openHour' => Carbon::createFromTime(8, 0, 0)->toTimeString(), // 08:00:00
                'closeHour' => Carbon::createFromTime(22, 0, 0)->toTimeString(), // 22:00:00
            ],
            [
                'user_id' => '2',
                'description' => 'Kedai Kopi Modern dengan berbagai varian kopi spesial',
                'openHour' => Carbon::createFromTime(7, 0, 0)->toTimeString(), // 07:00:00
                'closeHour' => Carbon::createFromTime(21, 0, 0)->toTimeString(), // 21:00:00
            ],
            [
                'user_id' => '3',
                'description' => 'Restoran seafood dengan bahan baku segar langsung dari nelayan',
                'openHour' => Carbon::createFromTime(10, 0, 0)->toTimeString(), // 10:00:00
                'closeHour' => Carbon::createFromTime(23, 0, 0)->toTimeString(), // 23:00:00
            ],
        ];

        foreach ($merchants as $merchant) {
            Merchant::create($merchant);
        }

        $this->command->info('Merchants seeded successfully!');
    }
}
