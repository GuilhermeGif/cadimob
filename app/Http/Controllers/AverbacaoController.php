<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Averbacao;
use App\Models\Imovel;
use Inertia\Inertia;

class AverbacaoController extends Controller
{
    //
    public function index($imovel_id) {
        $imovel = Imovel::findOrFail($imovel_id);
        $averbacoes = $imovel->averbacoes;

        return inertia('Imoveis/Averbacoes/Index', [
            'imovel' => $imovel,
            'averbacoes' => $averbacoes,
        ]);
    }

    public function create($imovel_id)
    {
        return inertia('Imoveis/Averbacoes/CriarAverbacao', [
            'imovelId' => $imovel_id,
        ]);
    }

    public function store (Request $request, $imovel_id) {
        $data = $request->validated();
        $imovel = Imovel::where('id', $request->imovel_id)->first();
        $evento = $request->input('evento');
        

        // Lógica para os eventos
        switch ($evento) {
            case 'Cancelamento':
                if ($imovel->situacao == 0) {
                    return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'Imóvel já está inativo');
                } else {
                    $imovel->situacao = 0;
                    $imovel->save();
                }
                break;
            
            case 'Reativação':
                if ($imovel->situacao == 1) {
                    return redirect('/imoveis/' . $request->imovel_id)->with('error_message', 'Imóvel já está ativo');
                } else {
                    $imovel->situacao = 1;
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

        return redirect()->route('averbacoes.index', $imovel_id)->with('success', 'Averbação criada com sucesso.');
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
