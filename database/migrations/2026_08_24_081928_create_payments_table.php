<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration QRIS lengkap & aman dijalankan kapan pun:
 * setiap langkah dicek dulu, jadi tidak error walau sebagian sudah pernah dibuat.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1) Kolom bukti pembayaran di tabel payments
        if (! Schema::hasColumn('payments', 'proof_path')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('proof_path')->nullable();
            });
        }
        if (! Schema::hasColumn('payments', 'proof_uploaded_at')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->timestamp('proof_uploaded_at')->nullable();
            });
        }

        // 2) Kolom method jadi string supaya bisa 'cod' dan 'qris' (aman walau sebelumnya enum)
        DB::statement("ALTER TABLE payments MODIFY method VARCHAR(20) NOT NULL DEFAULT 'cod'");

        // 3) Tabel data QRIS & DANA (diatur admin)
        if (! Schema::hasTable('qris')) {
            Schema::create('qris', function (Blueprint $table) {
                $table->id();
                $table->string('image')->nullable();
                $table->string('dana_number', 30)->nullable();
                $table->string('account_name', 100)->nullable();
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('qris');

        foreach (['proof_path', 'proof_uploaded_at'] as $column) {
            if (Schema::hasColumn('payments', $column)) {
                Schema::table('payments', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }
    }
};
