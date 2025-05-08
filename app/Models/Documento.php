<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Documento extends Model implements Auditable
{
    //
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'imovel_id',
        'nome_arquivo',
        'caminho_arquivo',
    ];

    public function imovel() 
    {
        return $this->belongsTo(Imovel::class);
    }
}
