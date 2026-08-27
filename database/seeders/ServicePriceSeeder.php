<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ServicePrice;
use Illuminate\Database\Seeder;

class ServicePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServicePrice::create([
            'name' => 'Illustrasi Karakter (Chibi)',
            'description' => 'Gambar karakter gaya  chibi, satu karakter, background polos',
            'price' => 750000,
        ]);

        ServicePrice::create([
            'name' => 'Illustrasi Karakter (Semi Realistis)',
            'description' => 'Gambar karakter gaya semi realistis, satu karakter, dengan background sederhana.',
            'price' => 150000,
        ]);

        ServicePrice::create([
            'name' => 'Portrait Realistis',
            'description' => 'Gambar wajah/portrait realis dari foto referensi.',
            'price' => 250000,
        ]);

    }
}
