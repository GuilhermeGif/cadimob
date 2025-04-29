<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Averbacao extends Model
{
    //
    protected $table = 'averbacoes';
    protected $fillable = ['imovel_id', 'evento', 'medida', 'descricao', 'data_averbacao'];
    
}
