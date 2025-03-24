<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Imovel;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    // Upload de documentos
    public function store(Request $request, Imovel $imovel)
    {
        $request->validate([
            'documentos' => 'required|array|max:5', // Máximo de 5 documentos
            'documentos.*' => 'file|mimes:jpg,jpeg,png,pdf|max:3072', // 3MB máximo por arquivo
        ]);

        foreach ($request->file('documentos') as $arquivo) {
            $caminho = $arquivo->store('documentos'); // Salva o arquivo na pasta "storage/app/documentos"
            $imovel->documentos()->create([
                'nome_arquivo' => $arquivo->getClientOriginalName(),
                'caminho_arquivo' => $caminho,
            ]);
        }

        return redirect()->back()->with('success', 'Documentos anexados com sucesso!');
    }

    //Exclusao de arquivo
    public function destroy(Documento $documento)
    {
        Storage::delete($documento->caminho_arquivo); // Remove o arquivo do storage
        $documento->delete(); // Remove o registro do banco de dados

        return redirect()->back()->with('success', 'Documento excluído com sucesso!');
    }

    //Download de documentos
    public function download(Documento $documento)
    {
        return Storage::download($documento->caminho_arquivo, $documento->nome_arquivo);
    }
}
