<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_config', function (Blueprint $table) {
            $table->enum('update_type', ['app', 'external'])->default('app');
            $table->string('min_version');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_config', function (Blueprint $table) {
            //
        });
    }
};
