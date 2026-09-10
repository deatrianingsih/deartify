<?php

namespace Database\Seeders;

use App\Models\ServicePrice;
use Illuminate\Database\Seeder;

class ServicePriceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Sketch (Hitam Putih)', 'description' => 'Gambar sketsa hitam putih, satu karakter.', 'price' => 50000],
            ['name' => 'Line Art', 'description' => 'Gambar line art rapi tanpa warna, satu karakter.', 'price' => 70000],
            ['name' => 'Full Color', 'description' => 'Gambar full color lengkap dengan shading, satu karakter.', 'price' => 150000],
            ['name' => 'Chibi', 'description' => 'Gambar karakter gaya chibi, imut dan sederhana.', 'price' => 80000],
            ['name' => 'Background', 'description' => 'Gambar latar belakang/pemandangan tanpa karakter.', 'price' => 30000],
            ['name' => 'Semi Realis', 'description' => 'Gambar karakter gaya semi realis, satu karakter.', 'price' => 150000],
            ['name' => 'Portrait Realis', 'description' => 'Gambar wajah/portrait realis dari foto referensi.', 'price' => 250000],
            ['name' => 'Icon/Avatar', 'description' => 'Gambar ikon profil bulat, cocok untuk media sosial.', 'price' => 40000],
            ['name' => 'Emote/Sticker', 'description' => 'Gambar emote/sticker ekspresif untuk chat atau streaming.', 'price' => 35000],
            ['name' => 'Couple/Group Art', 'description' => 'Gambar dua karakter atau lebih dalam satu ilustrasi.', 'price' => 200000],
        ];

        foreach ($services as $service) {
            ServicePrice::create($service);
        }
    }
}