<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;
use Illuminate\Http\Request;

class UpdateService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories,
        private ReceitasService $receitasService
    ) {

    }

    public function updateReceita(int $receitaId, Request $request)
    {
        $haveReceita = $this->receitasService->haveReceitaCreated($request->descricao, data_get($data, "data"));

        if(!$haveReceita){
            return $this->receitasRepositories->update($receitaId, $request->all());
        }

        return false;
    }
}
