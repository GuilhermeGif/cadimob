<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    //
    use HasFactory;
    
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
