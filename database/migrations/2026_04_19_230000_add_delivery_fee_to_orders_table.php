<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // delivery_fee = ongkir yang menjadi pendapatan driver
            // price tetap = total yang dibayar user (makanan + ongkir)
            $table->decimal('delivery_fee', 15, 2)->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_fee');
        });
    }
};
