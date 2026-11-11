<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

        DB::statement("ALTER TABLE payments MODIFY method VARCHAR(20) NOT NULL DEFAULT 'cod'");

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
    }
};
