<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix existing category image paths
        DB::statement("UPDATE categories SET image = REPLACE(image, 'public/uploads/', 'uploads/') WHERE image LIKE 'public/uploads/%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the change if needed
        DB::statement("UPDATE categories SET image = REPLACE(image, 'uploads/', 'public/uploads/') WHERE image LIKE 'uploads/%'");
    }
};
