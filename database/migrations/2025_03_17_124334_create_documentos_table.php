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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis')->onDelete('cascade'); // Relacionamento com a tabela de imóveis
            $table->string('nome_arquivo'); // Nome do arquivo
            $table->string('caminho_arquivo'); // Caminho onde o arquivo está salvo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
