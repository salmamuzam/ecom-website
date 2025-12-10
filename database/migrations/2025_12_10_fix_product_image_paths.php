<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Fix existing product image paths by removing 'public/' prefix
        DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'like', 'public/%')
            ->update([
                    'image' => DB::raw("REPLACE(image, 'public/', '')")
                ]);
    }

    public function down(): void
    {
        // Optionally restore the old paths
        DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'not like', 'public/%')
            ->update([
                    'image' => DB::raw("CONCAT('public/', image)")
                ]);
    }
};
