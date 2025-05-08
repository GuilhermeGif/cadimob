<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImovelRequest;
use App\Http\Requests\DocumentoRequest;
use App\Models\Imovel;
use App\Models\Pessoa;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ImovelController extends Controller
{
    //
    public function index()
    {
        $imoveis = Imovel::with('contribuinte')->paginate(10);
        return Inertia::render('Imoveis/Index', ['imoveis' => $imoveis]);
    }

    public function store(StoreImovelRequest $request)
{

    $data = $request->validated();

    $imovel = Imovel::create($data);

    if ($request->hasFile('documentos')) {
        foreach ($request->file('documentos') as $file) {
            $caminho_arquivo = $file->store('arquivos', 'public');
            Documento::create([
                'nome_arquivo' => $file->getClientOriginalName(),
                'caminho_arquivo' => $caminho_arquivo,
                'id' => $imovel->id,
            ]);
        }
    }

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
        $imovel = Imovel::with('contribuinte', 'documentos:id,nome_arquivo,caminho_arquivo,imovel_id')->findOrFail($id);

        $contribuintes = Pessoa::all(['id', 'nome']);

        return Inertia::render('Imoveis/Edit', [
            'imovel' => $imovel,
            'contribuintes' => $contribuintes,
            'documentos' => $imovel->documentos,
        ]);
    }

    public function update(Request $request, Imovel $imovel)
{
    $imovel = Imovel::findOrFail($request->id);
    
    $dadosAtualizados = $request->all();

    $imovel->update($dadosAtualizados);


    return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
}



    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        $imovel->delete();
        return redirect()->route('imoveis.index')->with('success', 'Imóvel excluído com sucesso!');
    }

    public function documentoStore(DocumentoRequest $request, $id)
{
    $imovel = Imovel::findOrFail($id); // Encontra o imóvel pelo ID da URL

    $documentos = [];
    foreach ($request->file('documentos') as $documento) {
        if ($documento->isValid()) {
            $name = $documento->getClientOriginalName();
            $path = $documento->store('arquivos', 'public');

            $documento = Documento::create([
                'nome_arquivo' => $name,
                'caminho_arquivo' => $path,
                'imovel_id' => $imovel->id, // Usa o ID do imóvel encontrado
            ]);

            $documentos[] = $documento;
        }
    }

    return response()->json(['documentos' => $documentos, 'message' => 'Documentos adicionados com sucesso!']);
}

public function documentoDestroy($id)
{
    $documento = Documento::findOrFail($id);
    $caminho_arquivo = $documento->caminho_arquivo;

    if ($documento) {
        if (Storage::disk('public')->exists($caminho_arquivo)) {
            $documento->delete();
            Storage::disk('public')->delete($caminho_arquivo);
            return response()->json(['message' => 'Documento deletado com sucesso']);
        } else {
            return response()->json(['error' => 'Documento não encontrado'], 404);
        }
    }

    return response()->json(['error' => 'Documento não encontrado'], 404);
}

public function documentoDownload($id)
{

    $documento = Documento::findOrFail($id);
    $caminho_arquivo = $documento->caminho_arquivo;

    // Verifica se o arquivo existe
    $caminhoCompleto = storage_path('app/public/' . $caminho_arquivo);

    if (!file_exists($caminhoCompleto)) {
        abort(404, 'Arquivo não encontrado.');
    }

    // Constrói o caminho completo do arquivo
    $caminhoCompleto = storage_path('app/public/' . $documento->caminho_arquivo);

    // Verifica se o arquivo existe
    if (!file_exists($caminhoCompleto)) {
        abort(404, 'Arquivo não encontrado.');
    }

    return response()->download($caminhoCompleto);
}
}
