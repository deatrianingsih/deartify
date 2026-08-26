<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_price_id')->constrained('service_prices')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->string('reference_image', 255)->nullable();
            $table->string('recipient_name', 128);
            $table->string('recipient_email', 20);
            $table->text('shipping_address');
            $table->enum('status', ['pending', 'in_progress', 'shipped', 'completed'])->default('pending');
            $table->dateTime('shipped_at')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};