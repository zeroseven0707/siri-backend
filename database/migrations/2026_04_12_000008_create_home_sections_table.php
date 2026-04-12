<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('key')->unique(); // e.g. banner, promo, featured_stores, services
            $table->enum('type', ['banner', 'store_list', 'food_list', 'service_list', 'promo', 'custom']);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
