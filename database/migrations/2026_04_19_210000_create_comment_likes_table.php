<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('comment_id')->constrained('post_comments')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['comment_id', 'user_id']);
        });

        Schema::table('post_comments', function (Blueprint $table) {
            $table->unsignedInteger('likes_count')->default(0)->after('body');
            $table->foreignUuid('parent_id')->nullable()->constrained('post_comments')->nullOnDelete()->after('post_id');
        });
    }

    public function down(): void
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['likes_count', 'parent_id']);
        });
        Schema::dropIfExists('comment_likes');
    }
};
