<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('device')->nullable();       // e.g. iPhone 14, Samsung Galaxy
            $table->string('platform')->nullable();     // iOS, Android, Web
            $table->string('app_version')->nullable();
            $table->boolean('success')->default(true);
            $table->timestamp('logged_in_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
