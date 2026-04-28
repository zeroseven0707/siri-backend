<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update home_section_items where action_type = 'service'
        // Change action_value from UUID to slug

        $items = DB::table('home_section_items')
            ->where('action_type', 'service')
            ->get();

        foreach ($items as $item) {
            // Try to find service by UUID
            $service = DB::table('services')
                ->where('id', $item->action_value)
                ->first();

            if ($service) {
                // Update action_value to use slug instead of UUID
                DB::table('home_section_items')
                    ->where('id', $item->id)
                    ->update(['action_value' => $service->slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: change slug back to UUID
        $items = DB::table('home_section_items')
            ->where('action_type', 'service')
            ->get();

        foreach ($items as $item) {
            // Try to find service by slug
            $service = DB::table('services')
                ->where('slug', $item->action_value)
                ->first();

            if ($service) {
                // Update action_value back to UUID
                DB::table('home_section_items')
                    ->where('id', $item->id)
                    ->update(['action_value' => $service->id]);
            }
        }
    }
};
