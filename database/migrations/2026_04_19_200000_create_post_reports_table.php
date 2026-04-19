<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('reason');
            $table->timestamps();

            $table->unique(['post_id', 'user_id']); // 1 laporan per user per post
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_reports');
    }
};
