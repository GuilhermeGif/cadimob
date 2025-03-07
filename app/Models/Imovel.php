<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imovel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "imoveis";
    protected $primarykey = 'id';
    protected $fillable = [
        "tipo","area_terreno","area_Edificacao","logradouro",
        "numero","bairro","complemento", "contribuinte_id", 'situacao'
    ];

    public function contribuinte()
    {
        return $this->belongsTo(Pessoa::class,'contribuinte_id');
    }
}

