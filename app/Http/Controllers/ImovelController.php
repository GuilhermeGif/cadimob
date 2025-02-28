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
        $data = $request->validate([
            'tipo'=> 'required|string',
            'area_terreno'=> 'nullable|numeric',
            'area_edificacao'=> 'nullable|numeric',
            'logradouro'=> 'required|string',
            'numero'=> 'required|integer',
            'bairro'=> 'required|string',
            'complemento'=> 'nullable|string',
            'contribuinte_id'=> 'required|exists:pessoas,id',
        ]);
        
        Imovel::create($data);

        return redirect()->route('imoveis.index')->with('success','Imóvel cadastrado com sucesso!');
    }

    public function create()
    {
        return Inertia::render('Imoveis/Create', [
            'imovel'=> new Imovel(),
            'contribuintes' => Pessoa::all(['id', 'nome']),
        ]);
    }

    public function edit(Imovel $imovel)
    {
        return Inertia::render('Imoveis/Edit', [
            'imovel' => $imovel,
            'contribuintes' => Pessoa::all()
        ]);
    }

    public function update(Request $request, Imovel $imovel)
    {
        $data = $request->validate([
            'tipo' => 'required|string',
            'area_terreno' => 'nullable|numeric',
            'area_edificacao' => 'nullable|numeric',
            'logradouro' => 'required|string',
            'numero' => 'required|integer',
            'bairro' => 'required|string',
            'complemento' => 'nullable|string',
            'contribuinte_id' => 'required|exists:pessoas,id',
        ]);

        $imovel->update($data);

        return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        $imovel->delete();
        return redirect()->route('imoveis.index')->with('success', 'Imóvel excluído com sucesso!');
    }
}
