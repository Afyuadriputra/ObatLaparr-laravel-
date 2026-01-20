<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'code')) {
                $table->string('code')->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'tracking_token')) {
                $table->string('tracking_token')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->integer('subtotal')->default(0)->after('note');
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('MENUNGGU_KONFIRMASI')->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'fulfillment_type')) {
                $table->string('fulfillment_type')->default('delivery')->after('phone');
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->nullable()->after('fulfillment_type');
            }
            if (!Schema::hasColumn('orders', 'note')) {
                $table->string('note')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'code')) $table->dropColumn('code');
            if (Schema::hasColumn('orders', 'tracking_token')) $table->dropColumn('tracking_token');
            if (Schema::hasColumn('orders', 'subtotal')) $table->dropColumn('subtotal');
            if (Schema::hasColumn('orders', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('orders', 'fulfillment_type')) $table->dropColumn('fulfillment_type');
            if (Schema::hasColumn('orders', 'address')) $table->dropColumn('address');
            if (Schema::hasColumn('orders', 'note')) $table->dropColumn('note');
        });
    }
};
