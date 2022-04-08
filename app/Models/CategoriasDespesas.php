<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasDespesas extends Model
{
    protected $table = 'categorias_despesas';

    protected $fillable = [
        "descricao"
    ];
}
