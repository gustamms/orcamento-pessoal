<?php

namespace App\Repositories;

use App\Models\Despesas;
use Exception;
use Illuminate\Support\Facades\DB;

class DespesasRepository
{
    public function insert(array $data)
    {
        try {
            DB::beginTransaction();

            Despesas::create($data);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception("Erro ao registrar dado no banco de dados");
        }
    }

    public function getDespesaBySimpleQuery(string $column, string $value)
    {
        return Despesas::where($column, $value)->get()->toArray();
    }

}
