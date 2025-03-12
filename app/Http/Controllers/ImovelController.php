<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImovelController extends Controller
{
    //
    public function index()
    {
        $imoveis = Imovel::with('contribuinte')->paginate(10);
        return Inertia::render('Imoveis/Index', ['imoveis' => $imoveis]);
    }

    public function store(Request $request)
{
    $request->validate([
        'tipo' => 'required|in:Terreno,Casa,Apartamento',
        'area_terreno' => [
            'nullable',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->tipo === 'Terreno' && $value <= 0) {
                    $fail('A área do terreno é obrigatória e deve ser maior que zero para terrenos.');
                }
                if ($request->tipo === 'Casa' && $value <= 0) {
                    $fail('A área do terreno é obrigatória e deve ser maior que zero para casas.');
                }
            },
        ],
        'area_edificacao' => [
            'nullable',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->tipo === 'Casa' && $value <= 0) {
                    $fail('A área da edificação é obrigatória e deve ser maior que zero para casas.');
                }
                if ($request->tipo === 'Apartamento' && $value <= 0) {
                    $fail('A área da edificação é obrigatória e deve ser maior que zero para apartamentos.');
                }
                if ($request->tipo === 'Terreno' && $value != 0) {
                    $fail('A área da edificação deve ser zero para terrenos.');
                }
            },
        ],
        'logradouro' => 'required|string',
        'numero' => 'required|integer',
        'bairro' => 'required|string',
        'complemento' => 'nullable|string',
        'contribuinte_id' => 'required|exists:pessoas,id',
    ], [
        // Mensagens personalizadas
        'tipo.required' => 'O campo tipo é obrigatório.',
        'tipo.in' => 'O tipo de imóvel deve ser Terreno, Casa ou Apartamento.',
        'area_terreno.min' => 'A área do terreno deve ser maior ou igual a zero.',
        'area_edificacao.min' => 'A área da edificação deve ser maior ou igual a zero.',
        'logradouro.required' => 'O campo logradouro é obrigatório.',
        'numero.required' => 'O campo número é obrigatório.',
        'numero.integer' => 'O campo número deve ser um número inteiro.',
        'bairro.required' => 'O campo bairro é obrigatório.',
        'contribuinte_id.required' => 'O campo contribuinte é obrigatório.',
        'contribuinte_id.exists' => 'O contribuinte selecionado não existe.',
    ]);

    Imovel::create($request->all());

    return redirect()->route('imoveis.index')->with('success', 'Imóvel cadastrado com sucesso!');
}

    public function create()
    {
        return Inertia::render('Imoveis/Create', [
            'imovel'=> new Imovel(),
            'contribuintes' => Pessoa::all(['id', 'nome']),
        ]);
    }

    public function edit($id)
    {
        $imovel = Imovel::with('contribuinte')->findOrFail($id);

        $contribuintes = Pessoa::all(['id', 'nome']);

        return Inertia::render('Imoveis/Edit', [
            'imovel' => $imovel,
            'contribuintes' => $contribuintes,
        ]);
    }

    public function update(Request $request, Imovel $imovel)
{
    $request->validate([
        'tipo' => 'required|in:Terreno,Casa,Apartamento',
        'area_terreno' => [
            'nullable',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->tipo === 'Terreno' && $value <= 0) {
                    $fail('A área do terreno é obrigatória e deve ser maior que zero para terrenos.');
                }
                if ($request->tipo === 'Casa' && $value <= 0) {
                    $fail('A área do terreno é obrigatória e deve ser maior que zero para casas.');
                }
            },
        ],
        'area_edificacao' => [
            'nullable',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->tipo === 'Casa' && $value <= 0) {
                    $fail('A área da edificação é obrigatória e deve ser maior que zero para casas.');
                }
                if ($request->tipo === 'Apartamento' && $value <= 0) {
                    $fail('A área da edificação é obrigatória e deve ser maior que zero para apartamentos.');
                }
                if ($request->tipo === 'Terreno' && $value != 0) {
                    $fail('A área da edificação deve ser zero para terrenos.');
                }
            },
        ],
        'logradouro' => 'required|string',
        'numero' => 'required|integer',
        'bairro' => 'required|string',
        'complemento' => 'nullable|string',
        'contribuinte_id' => 'required|exists:pessoas,id',
    ], [
        // Mensagens personalizadas
        'tipo.required' => 'O campo tipo é obrigatório.',
        'tipo.in' => 'O tipo de imóvel deve ser Terreno, Casa ou Apartamento.',
        'area_terreno.min' => 'A área do terreno deve ser maior ou igual a zero.',
        'area_edificacao.min' => 'A área da edificação deve ser maior ou igual a zero.',
        'logradouro.required' => 'O campo logradouro é obrigatório.',
        'numero.required' => 'O campo número é obrigatório.',
        'numero.integer' => 'O campo número deve ser um número inteiro.',
        'bairro.required' => 'O campo bairro é obrigatório.',
        'contribuinte_id.required' => 'O campo contribuinte é obrigatório.',
        'contribuinte_id.exists' => 'O contribuinte selecionado não existe.',
    ]);

    $imovel->update($request->all());

    return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
}

    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        $imovel->delete();
        return redirect()->route('imoveis.index')->with('success', 'Imóvel excluído com sucesso!');
    }
}
