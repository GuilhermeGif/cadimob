<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Pessoa extends Model implements Auditable
{
    //
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    

    protected $connection = 'mysql';
    protected $table = 'pessoas';

    protected $primarykey = 'id';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'sexo',
        'telefone',
        'email',
    ];

}
