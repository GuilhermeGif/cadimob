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
        //
        Schema::create('averbacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained()->onDelete('cascade'); // Chave estrangeira para imóveis
            $table->string('evento'); // Aumento, Redução, Observação, Cancelamento, Reativação
            $table->decimal('medida', 10, 2)->nullable(); // Medida em m²
            $table->text('descricao')->nullable(); // Descrição do evento
            $table->timestamps(); // Campos de data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
