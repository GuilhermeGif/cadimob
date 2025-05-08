<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Detalhado de Imóveis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        td {
            width: 50%;
            border: 1px solid;
            text-align: left;
            padding: 10px;
        }
        body {
            font-size: 14px;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 4px;
        }
        h3 {
            font-size: 17px;
            margin-top: 4px;
        }
        h4 {
            font-size: 15px;
            margin-bottom: 5px;
        }
        img {
            width: 60px; 
        }
        div {
            text-align: center;
        }
        .descricao {
            width: 55%;
            text-align: justify;
        }
        .data, .evento, .medida {
            width: 15%;
            text-align: center;
        }
        .averbacao-table td {
            padding: 5px;
        }
        .averbacao-table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .imovel-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="img/brasao.png" alt="Brasão">
            <h2>PREFEITURA MUNICIPAL DE SÃO LEOPOLDO</h2>
            <h3>Estado do Rio Grande do Sul</h3>
            <h4>RELATÓRIO DETALHADO DE IMÓVEIS</h4>
        </div>
    </header>
    <main>
    <table class="imovel-table">
            <tbody>
                <tr>
                    <td><strong>Inscrição Municipal: </strong>{{ $imovel->id }}</td>
                    <td><strong>Situação: </strong>{{ $imovel->situacao }}</td>
                </tr>
                <tr>
                    <td><strong>Contribuinte: </strong>{{ $imovel->contribuinte->nome }}</td>
                    <td><strong>Tipo: </strong>{{ $imovel->tipo }}</td>
                </tr>
                <tr>
                    <td><strong>Bairro: </strong>{{ $imovel->bairro }}</td>
                    <td><strong>Logradouro: </strong>{{ $imovel->logradouro }}</td>
                </tr>
                <tr>
                    <td><strong>Número: </strong>{{ $imovel->numero }}</th>
                    <td><strong>Complemento: </strong>{{ $imovel->complemento }}</td>
                </tr>
                <tr>
                    <td><strong>Área do Terreno: </strong>{{ $imovel->area_terreno }}m²</td>
                    <td><strong>Área da Edificação: </strong>{{ $imovel->area_edificacao }}m²</td>
                </tr>
            </tbody>
        </table>
        <div>
            <h4>AVERBAÇÕES</h4>
        </div>
        <table class="averbacao-table">
            <thead>
                <tr>
                    <th class="data">Data</th>
                    <th class="evento">Evento</th>
                    <th class="medida">Medida(m²)</th>
                    <th class="descricao">Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($imovel->averbacoes as $averbacao)
                <tr>
                    <td class="data">{{ date('d/m/Y', strtotime($averbacao->data_averbacao)) }}</td>
                    <td class="evento">{{ $averbacao->evento }}</td>
                    <td class="medida">{{ $averbacao->medida }}</td>
                    <td class="descricao">{{ $averbacao->descricao }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>