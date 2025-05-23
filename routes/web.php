<?php

use App\Http\Controllers\ImovelController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AverbacaoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        //Route::resource('users', UserController::class);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
        // Rotas para usuários
        Route::resource('users', UserController::class);
        Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:viewAny,App\Models\User');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:update,App\Models\User');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:update,App\Models\User');
    });


Route::get('/pessoas/index', [PessoaController::class, 'index'])->name('pessoas.index');
Route::get('/pessoas/create', [PessoaController::class, 'create'])->name('pessoas.create');
Route::get('/pessoas/{id}/edit', [PessoaController::class, 'edit'])->name('pessoas.edit');
Route::put('/pessoas/{id}', [PessoaController::class, 'update'])->name('pessoas.update');
Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy'])->name('pessoas.destroy');
Route::post('/pessoas/store', [PessoaController::class, 'store'])->name('pessoas.store');

Route::get('/imoveis/index', [ImovelController::class, 'index'])->name('imoveis.index');
Route::get('/imoveis/create', [ImovelController::class, 'create'])->name('imoveis.create');
Route::get('/imoveis/{id}/edit', [ImovelController::class, 'edit'])-> name('imoveis.edit');
Route::put('/imoveis/{id}', [ImovelController::class, 'update'])->name('imoveis.update');
Route::delete('/imoveis/{id}', [ImovelController::class, 'destroy'])->name('imoveis.destroy');
Route::post('/imoveis/store', [ImovelController::class, 'store'])->name('imoveis.store');

// Rotas para documentos
Route::post('/imoveis/{id}/documentos', [ImovelController::class, 'documentoStore'])
    ->middleware([HandlePrecognitiveRequests::class])
    ->name('documentos.store');

Route::delete('/documentos/{id}', [ImovelController::class, 'documentoDestroy'])
    ->name('documentos.destroy');

Route::get('/documentos/{id}/download', [ImovelController::class, 'documentoDownload'])
    ->name('documentos.download');
    

// Rotas para averbações
Route::get('/imoveis/{imovel_id}/averbacoes', [AverbacaoController::class, 'index'])->name('averbacoes.index');
Route::get('/imoveis/{imovel_id}/averbacoes/create', [AverbacaoController::class, 'create'])->name('averbacoes.create');
Route::post('/imoveis/averbacoes', [AverbacaoController::class, 'store'])->name('averbacoes.store');
Route::get('/imoveis/{imovel_id}/averbacoes/{id}/edit', [AverbacaoController::class, 'edit'])->name('averbacoes.edit');
Route::put('/imoveis/{imovel_id}/averbacoes/{id}', [AverbacaoController::class, 'update'])->name('averbacoes.update');
Route::get('/imoveis/{imovel_id}/averbacoes/{id}', [AverbacaoController::class, 'show'])->name('averbacoes.show');

// Rotas para relatorios
Route::get('/relatorios/sintetico', [RelatorioController::class, 'relatorioSintetico'])->name('relatorios.sintetico');
Route::get('/relatorios/individual/{id}', [RelatorioController::class, 'relatorioIndividual'])->name('relatorios.individual');

// Rotas para auditoria
Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditorias.index');



    // Rotas para os perfis de autorização
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', function () {
            // Apenas usuários com acesso de administrador
        })->middleware('can:access-admin');
    
        Route::get('/system-admin', function () {
            // Apenas usuários com acesso de administrador do sistema
        })->middleware('can:access-system-admin');
    
        Route::get('/attendant', function () {
            // Apenas atendentes
        })->middleware('can:access-attendant');
    });


require __DIR__.'/auth.php';
