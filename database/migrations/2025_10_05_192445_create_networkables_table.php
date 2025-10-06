<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('networkables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('network_id')->constrained()->onDelete('cascade');
            $table->morphs('networkable'); // cria networkable_id e networkable_type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('networkables');
    }
};
