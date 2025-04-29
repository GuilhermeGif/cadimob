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
        Schema::create('averbacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis', 'id')->onDelete('cascade');
            $table->string('evento');
            $table->double('medida')->nullable();
            $table->longText('descricao')->nullable();
            $table->date('data_averbacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('averbacaos');
    }
};
