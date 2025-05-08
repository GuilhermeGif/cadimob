<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StorePessoaRequest;
use App\Models\Pessoa;
use Inertia\Inertia;
use Carbon\Carbon;


class PessoaController extends Controller
{
    //
       // LISTAR REGISTROS (READ)
    public function index()
    {
        $pessoas = Pessoa::paginate(10);
        return Inertia::render('Pessoas/Index', compact('pessoas'));
    }

    // FORMULÁRIO DE CRIAÇÃO (CREATE)
    public function create()
    {
        return Inertia::render('Pessoas/Create');
    }

    // ARMAZENAR NOVO REGISTRO (STORE)
    public function store(StorePessoaRequest $request)
{   
    Pessoa::create($request->validated());

    return redirect()->route('pessoas.index')->with('success', 'Pessoa cadastrada com sucesso!');
}

    //  FORMULÁRIO DE EDIÇÃO (EDIT)
    public function edit($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        return Inertia::render('Pessoas/Edit', ['pessoa' => $pessoa]);
    }

    //  ATUALIZAR REGISTRO (UPDATE)
    public function update(Request $request, Pessoa $pessoa)
{
    $pessoa = Pessoa::findOrFail($request->id);

    $dadosAtualizados = $request->all();

    $pessoa->update($dadosAtualizados);

    return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
}

    // EXCLUIR REGISTRO (DELETE)
    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->delete();

        return redirect()->route('pessoas.index')->with('success', 'Registro excluido com sucesso!');
    }
}

