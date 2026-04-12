<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Driver yang sudah dipilih sistem tapi belum confirmed oleh user
            $table->foreignUuid('assigned_driver_id')
                ->nullable()
                ->after('driver_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['assigned_driver_id']);
            $table->dropColumn('assigned_driver_id');
        });
    }
};
