<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Imovel;


class RelatorioController extends Controller
{
    //
    public function relatorioSintetico()
    {
        $imoveis = Imovel::with('contribuinte')->get();

        $pdf = PDF::loadView('sintetico', ['imoveis' => $imoveis]);
        return $pdf->stream('relatorio_sintetico_imoveis.pdf');
    }

    public function relatorioIndividual($id)
    {
        $imovel = Imovel::with('contribuinte', 'averbacoes')->where('id', $id)->first();

        $pdf = PDF::loadView('individual', ['imovel' => $imovel]);
        return $pdf->download('relatorio_sintetico_imovel'.$id.'.pdf');
    }
}
