<?php

namespace App\Services\Receitas;

use App\Models\Receitas;
use App\Repositories\ReceitasRepositories;
use Illuminate\Http\Request;

class UpdateService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories,
        private ReceitasService      $receitasService,
        private Receitas             $receitas
    )
    {

    }

    public function updateReceita(int $receitaId, Request $request)
    {
        $haveReceita = $this->receitasService->haveReceitaCreated($request->descricao, $request->data);

        if (!$haveReceita) {
            return $this->receitasRepositories->update($this->receitas, $receitaId, $request->all());
        }

        return false;
    }
}
