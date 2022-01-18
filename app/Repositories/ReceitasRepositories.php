<?php

namespace App\Repositories;

use App\Models\Receitas;
use Illuminate\Support\Facades\DB;
use Exception;

class ReceitasRepositories
{
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

    public function getReceitaBySimpleQuery(string $column, string $value)
    {
        return Receitas::where($column, $value)->get()->toArray();
    }
}