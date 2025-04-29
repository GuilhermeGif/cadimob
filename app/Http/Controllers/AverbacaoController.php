<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAverbacaoRequest;
use Illuminate\Http\Request;
use App\Models\Averbacao;
use App\Models\Imovel;
use Inertia\Inertia;

class AverbacaoController extends Controller
{
    //
    public function index($imovel_id) {
        $averbacoes = Averbacao::where('imovel_id', $imovel_id)->get();

        return Inertia::render('Imoveis/Averbacoes/Index', [
            'averbacoes' => $averbacoes,
            'imovel_id' => $imovel_id,
        ]);
    }

    public function create($imovel_id)
    {
        return inertia('Imoveis/Averbacoes/Create', [
            'imovel_id' => $imovel_id,
        ]);
    }

    public function store (StoreAverbacaoRequest $request) {
        
        $data = [
            'evento' => $request->evento,
            'medida' => $request->medida,
            'descricao' => $request->descricao,
            'data_averbacao' => now(),
            'imovel_id' => $request->imovel_id,
        ];
        $imovel = Imovel::where('id', $request->imovel_id)->first();
        $evento = $request->input('evento');
        
        // Lógica para os eventos
        switch ($evento) {
            case 'Cancelamento':
                if ($imovel->situacao == 'Inativo') {
                    return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'Imóvel já está inativo');
                } else {
                    $imovel->situacao = 'Inativo';
                    $imovel->save();
                }
                break;
            
            case 'Reativação':
                if ($imovel->situacao == 'Ativo') {
                    return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'Imóvel já está ativo');
                } else {
                    $imovel->situacao = 'Ativo';
                    $imovel->save();
                }
                break;
                
            case 'Aumento Área Construída':
                $medida = $request->medida;
                if ($medida <= 0) {
                    return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'A área deve possuir um valor válido');
                } else {
                    $imovel->area_edificacao += $medida;
                    $imovel->save();
                }
                break;
                
                case 'Redução Área Construída':
                    $medida = $request->medida;
                    if ($imovel->area_edificacao < $medida) {
                        return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'A área deve ser menor que a área cadastrada');
                    } else {
                        $imovel->area_edificacao -= $medida;
                        $imovel->save();
                    }
                    break;
        }
        Averbacao::create($data);


        return redirect()->route('averbacoes.index', $request->imovel_id)->with('success', 'Averbação criada com sucesso.');
    }
    
    public function edit($imovel_id, $id)
    {
        $averbacao = Averbacao::findOrFail($id);
        return inertia('Imoveis/Averbacoes/EditarAverbacao', [
            'imovelId' => $imovel_id,
            'averbacao' => $averbacao,
        ]);
    }

    public function update(Request $request, $imovel_id, $id) {
        $request->validate([
            'evento' => 'required|string',
            'medida' => 'nullable|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);
    }

    public function show($id) {
        $averbacao = Averbacao::findOrFail($id);

        return Inertia::render('Imoveis/Averbacoes/VisualizarAverbacao', [
            'averbacao' => $averbacao
        ]);
    }
}
