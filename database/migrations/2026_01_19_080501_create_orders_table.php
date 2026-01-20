<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique(); // <-- wajib

            $table->string('customer_name');
            $table->string('phone');

            $table->string('fulfillment_type'); // delivery / pickup
            $table->text('address')->nullable();
            $table->text('note')->nullable();

            $table->integer('subtotal');

            $table->string('status')->default('MENUNGGU_KONFIRMASI');

            $table->string('tracking_token')->nullable()->unique();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['phone', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
