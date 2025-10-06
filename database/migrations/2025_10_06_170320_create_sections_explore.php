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
        Schema::create('sections_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título da seção (ex: "Filmes", "Ação", "Netflix")
            $table->enum('type', ['movies', 'series', 'genre', 'network', 'collection', 'custom']); // Tipo da seção
            $table->unsignedBigInteger('reference_id')->nullable(); // usado quando o tipo for genre, network, collection, custom, etc
            $table->integer('order')->default(0); // posição de exibição
            $table->boolean('is_active')->default(true); // ativa/desativa a seção no catálogo
            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections_catalog');
    }
};

