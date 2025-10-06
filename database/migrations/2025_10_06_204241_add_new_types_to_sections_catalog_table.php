<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela.
     */
    public function up(): void
    {
        Schema::table('sections_catalog', function (Blueprint $table) {
            // Define o novo conjunto de enums para a coluna 'type'
            $table->enum('type', [
                'movies', 
                'series', 
                'genre', 
                'network', 
                'collection', 
                'custom',
                'collections_list', // NOVO
                'networks_list',    // NOVO
                'genres_list',      // NOVO
            ])->change();
        });
    }

    /**
     * Reverte a criação da tabela.
     */
    public function down(): void
    {
        Schema::table('sections_catalog', function (Blueprint $table) {
            // Reverte para o conjunto anterior de enums
            $table->enum('type', [
                'movies', 
                'series', 
                'genre', 
                'network', 
                'collection', 
                'custom'
            ])->change();
        });
    }
};