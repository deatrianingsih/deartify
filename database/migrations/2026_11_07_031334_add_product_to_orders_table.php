<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('service_price_id');
            }
            if (! Schema::hasColumn('orders', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('product_id');
            }
        });

        // Pesanan produk tidak punya layanan, jadi service_price_id harus boleh kosong
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('service_price_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['product_id', 'quantity'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
