<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('app_config', function (Blueprint $table) {
            $table->boolean('enable_custom_splash')->default(false);
            $table->string('custom_splash_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('app_config', function (Blueprint $table) {
            $table->dropColumn([
                'enable_custom_splash',
                'custom_splash_image'
            ]);
        });
    }
};

