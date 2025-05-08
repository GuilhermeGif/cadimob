<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'data_nascimento' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $idade = Carbon::parse($value)->age;
                if ($idade < 18) {
                    $fail('O contribuinte deve ter pelo menos 18 anos.');
                }
            },
        ],
        'cpf' => [
            'required',
            'string',
            'unique:pessoas,cpf',
            function ($attribute, $value, $fail) {
                if (!validaCPF($value)) {
                    $fail('O CPF informado é inválido.');
                }
            },
        ],
        'sexo' => 'required|in:Masculino,Feminino',
        'telefone' => [
            'nullable',
            'string',
        ],
        'email' => 'required|email|unique:pessoas,email',
    ], [
        // Mensagens personalizadas
        'email.unique' => 'O e-mail informado já está em uso.',
        'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
    ]);
    
    Pessoa::create($request->all());

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
    $request->validate([
        'nome' => 'required|string|max:255',
        'data_nascimento' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $idade = Carbon::parse($value)->age;
                if ($idade < 18) {
                    $fail('O contribuinte deve ter pelo menos 18 anos.');
                }
            },
        ],
        'cpf' => [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                if (!validaCPF($value)) {
                    $fail('O CPF informado é inválido.');
                }
            },
        ],
        'sexo' => 'required|in:Masculino,Feminino',
        'telefone' => [
            'nullable',
            'string',
        ],
        'email' => [
            'required',
            'email',
        ]
    ], [
        // Mensagens personalizadas
        'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
    ]);

    $pessoa->update($request->all());

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

function validaCPF ($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
