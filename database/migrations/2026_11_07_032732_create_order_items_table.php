<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('order_items')) {
            return;
        }

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->string('item_type', 10);               // service | product
            $table->unsignedBigInteger('service_price_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
