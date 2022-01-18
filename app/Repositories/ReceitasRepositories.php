<?php

namespace App\Repositories;

use App\Models\Receitas;
use Illuminate\Support\Facades\DB;
use Exception;

class ReceitasRepositories
{
    public function list()
    {
        return Receitas::all()->toArray();
    }

    public function insert(array $data)
    {
        try {
            DB::beginTransaction();
            Receitas::create($data);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception("Erro ao registrar dado no banco de dados");
        }
    }

    public function getById(int $receitaId)
    {
        return Receitas::where("id", $receitaId)->get()->toArray();
    }
    
    public function getReceitaBySimpleQuery(string $column, string $value)
    {
        return Receitas::where($column, $value)->get()->toArray();
    }
}