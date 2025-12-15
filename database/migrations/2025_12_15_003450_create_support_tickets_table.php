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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->string('category'); 
            // movie | series | tv | app
        
            $table->string('problem');
        
            // 🔥 RELACIONAMENTO OPCIONAL
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_type')->nullable();
            // movie | series | tv
        
            $table->text('message')->nullable();
            $table->string('app_version')->nullable();
        
            $table->string('status')->default('open');
        
            $table->timestamps();
        
            $table->index(['item_type', 'item_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
