<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Imovel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function averbacoes()
    {
        return $this->hasMany(Averbacao::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}

