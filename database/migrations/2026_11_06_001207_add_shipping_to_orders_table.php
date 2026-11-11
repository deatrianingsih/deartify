   <?php

   use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'delivery_area')) {
                $table->string('delivery_area', 20)->default('local')->after('shipping_address');
            }
            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->decimal('shipping_fee', 12, 2)->default(0)->after('delivery_area');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['delivery_area', 'shipping_fee'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
