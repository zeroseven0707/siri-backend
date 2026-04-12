<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('body');
            $table->string('image')->nullable();
            $table->json('data')->nullable();          // extra payload untuk mobile
            $table->enum('target', ['all', 'user', 'driver'])->default('all');
            $table->foreignUuid('sent_by')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('recipient_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        // Tabel pivot: siapa saja yang sudah baca notif ini
        Schema::create('push_notification_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('push_notification_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('read_at')->useCurrent();
            $table->unique(['push_notification_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('push_notification_reads');
        Schema::dropIfExists('push_notifications');
    }
};
