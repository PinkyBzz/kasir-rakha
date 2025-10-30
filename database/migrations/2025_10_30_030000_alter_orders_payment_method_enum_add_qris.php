<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cash','transfer','qris') NOT NULL DEFAULT 'cash'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cash','transfer') NOT NULL DEFAULT 'cash'");
    }
};
