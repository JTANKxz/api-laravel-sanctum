<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_views', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('content_id');
            $table->enum('content_type', ['movie', 'series']);

            $table->string('device_id', 100);
            $table->date('viewed_date');

            $table->timestamps();

            $table->unique(
                ['device_id', 'content_id', 'content_type', 'viewed_date'],
                'unique_daily_view'
            );

            $table->index(['content_type', 'content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_views');
    }
};

