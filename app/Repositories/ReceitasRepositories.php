<?php

namespace App\Repositories;

use App\Models\Receitas;
use Illuminate\Support\Facades\DB;

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

            return false;
        }
    }

    public function getReceitaBySimpleQuery(string $column, string $value)
    {
        return Receitas::where($column, $value)->get()->toArray();
    }
}