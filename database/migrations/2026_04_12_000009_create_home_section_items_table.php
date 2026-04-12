<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_section_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('home_section_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('action_type')->nullable();  // route, url, store, food, service
            $table->string('action_value')->nullable(); // the target id or url
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_section_items');
    }
};
