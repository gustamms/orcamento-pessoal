<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class CreateService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories
    ) {
        
    }

    public function createInDatabase(Request $request)
    {
        $data = [
            "descricao" => $request->descricao,
            "valor" => $request->valor,
            "data" => date('Y-m-d', strtotime($request->data))
        ];

        $haveReceita = $this->haveReceitaCreated($request->descricao);

        if(!$haveReceita){
            return $this->receitasRepositories->insert($data);
        }
        
        return false;
    }

    //TODO: Fazer método verificar dentro do mês se houve receita com mesmo nome
    public function haveReceitaCreated(string $description): bool
    {
        $response = $this->receitasRepositories->getReceitaBySimpleQuery("descricao", $description);

        if(count($response)){
            return true;
        }

        return false;
    }
}