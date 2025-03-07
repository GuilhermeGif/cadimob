<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use Inertia\Inertia;
use Carbon\Carbon;

class PessoaController extends Controller
{
    //
       // 📌 LISTAR REGISTROS (READ)
    public function index()
    {
        $pessoas = Pessoa::paginate(10);
        return Inertia::render('Pessoas/Index', compact('pessoas'));
    }

    // 📌 FORMULÁRIO DE CRIAÇÃO (CREATE)
    public function create()
    {
        return Inertia::render('Pessoas/Create');
    }

    // 📌 ARMAZENAR NOVO REGISTRO (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|size:14|unique:pessoas,cpf',
            'sexo' => 'required|in:Masculino,Feminino',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:pessoas,email',
        ]);
        
        Pessoa::create($request->all());

        return redirect()->route('pessoas.index')->with('success', 'Pessoa cadastrada com sucesso!');
    }

    // 📌 MOSTRAR DETALHES DE UMA PESSOA
    public function show(Pessoa $pessoa)
    {
        return Inertia::render('Pessoas/Show', compact('pessoa'));
    }

    // 📌 FORMULÁRIO DE EDIÇÃO (EDIT)
    public function edit($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        return Inertia::render('Pessoas/Edit', ['pessoa' => $pessoa]);
    }

    // 📌 ATUALIZAR REGISTRO (UPDATE)
    public function update(Request $request, Pessoa $pessoa)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|size:14|unique:pessoas,cpf,' . $pessoa->id,
            'sexo' => 'required|in:Masculino,Feminino',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:pessoas,email,' . $pessoa->id,
        ]);

        $pessoa->update($request->all());

        return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
    }

    // 📌 EXCLUIR REGISTRO (DELETE)
    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->delete();

        return redirect()->route('pessoas.index')->with('success', 'Registro excluido com sucesso!');
    }
}
