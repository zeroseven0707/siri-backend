<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('device')->nullable()->after('name');
            $table->string('platform')->nullable()->after('device');
            $table->string('ip_address', 45)->nullable()->after('platform');
        });
    }

    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn(['device', 'platform', 'ip_address']);
        });
    }
};
