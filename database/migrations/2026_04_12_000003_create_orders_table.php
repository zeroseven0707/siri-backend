<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('service_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'accepted', 'on_progress', 'completed', 'cancelled'])->default('pending');
            $table->string('pickup_location');
            $table->string('destination_location');
            $table->decimal('price', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
