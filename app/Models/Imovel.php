<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    protected $table = "imoveis";
    protected $fillable = [
        "tipo","area_terreno","area_Edificacao","logradouro",
        "numero","bairro","complemento", "contribuinte_id", 'situacao'
    ];

    public function contribuinte()
    {
        return $this->belongsTo(Pessoa::class,'contribuinte_id');
    }
}

