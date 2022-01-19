<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receitas extends Model
{
    protected $table = 'receitas';

    protected $fillable = [
        "descricao",
        "valor",
        "data",
        "updated_at"
    ];
    public static $rules = [
        "descricao" => "required|max:255",
        "valor" => "required|numeric",
    ];
}