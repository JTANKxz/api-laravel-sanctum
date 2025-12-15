<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            // 🔥 remove item_id
            if (Schema::hasColumn('support_tickets', 'item_id')) {
                $table->dropColumn('item_id');
            }

            // 🔥 adiciona item_name
            if (!Schema::hasColumn('support_tickets', 'item_name')) {
                $table->string('item_name')->nullable()->after('problem');
            }

            // 🔥 garante item_type
            if (!Schema::hasColumn('support_tickets', 'item_type')) {
                $table->enum('item_type', ['movie', 'series', 'tv'])->nullable()->after('item_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropColumn(['item_name', 'item_type']);
            $table->unsignedBigInteger('item_id')->nullable();
        });
    }
};
