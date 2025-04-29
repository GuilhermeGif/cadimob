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
        Schema::table('users', function (Blueprint $table) {
            // $table->char('profile', 1)->default('A')->after('password'); // A=Atendente, S=Admin Sistema, T=Admin TI
            //$table->string('cpf', 14)->unique()->after('profile');
            //$table->char('active', 1)->default('S')->after('cpf'); // S=Sim/Ativo, N=Não/Inativo
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
