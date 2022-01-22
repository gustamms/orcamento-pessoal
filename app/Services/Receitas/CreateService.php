<?php

namespace App\Services\Receitas;

use App\Models\Receitas;
use App\Repositories\ReceitasRepositories;
use Illuminate\Http\Request;

class CreateService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories,
        private ReceitasService $receitasService,
        private Receitas $receitas
    ) {

    }

    public function createInDatabase(Request $request)
    {
        $data = [
            "descricao" => $request->descricao,
            "valor" => $request->valor,
            "data" => date('Y-m-d', strtotime($request->data))
        ];

        $haveReceita = $this->receitasService->haveReceitaCreated($request->descricao, data_get($data, "data"));

        if(!$haveReceita){
            return $this->receitasRepositories->insert($this->receitas, $data);
        }

        return false;
    }
}
