<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
    protected $table = 'desapesas';

    protected $fillable = [
        "descricao",
        "valor",
        "updated_at"
    ];
    public static $rules = [
        "descricao" => "required|max:255",
        "valor" => "required|numeric",
    ];
}