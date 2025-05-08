<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Averbacao extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
    protected $table = 'averbacoes';
    protected $fillable = ['imovel_id', 'evento', 'medida', 'descricao', 'data_averbacao'];

    public function imovel()
    {
        $this->belongsTo(Imovel::class, 'imovel_id', 'id');
    }
    
}
