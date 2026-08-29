<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ServicePrice;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::create([
            'name'=> 'Dea Trianingsih',
            'email'=> 'customer@gmail.com',
            'password'=> bcrypt('password'),
            'phone'=> '081234567890',
            'role'=> 'customer',
        ]);
        $servicePrice = ServicePrice::first();

        $order = Order::create([
            'user_id'=>$customer->id,
            'service_price_id'=> $servicePrice->id,
            'description'=> 'Tolong gambar karakter anime dengan pose duduk santai.',
            'recipient_name'=> 'Dea Trianingsih',
            'recipient_phone'=> '081234567890',
            'shipping_address'=> 'Jl. Merdeka No.10, Semarang',
            'status'=> 'pending',
            'total_price'=> $servicePrice->price,
        ]);

        Payment::create([
            'order_id'=> $order->id,
            'user_id'=> $customer->id,
            'amount'=> $order->total_price,
            'method'=>'cod',
            'status'=>'pending,'
        ]);
    }
}
