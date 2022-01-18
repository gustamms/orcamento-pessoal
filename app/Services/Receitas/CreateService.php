<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;
use Illuminate\Http\Request;
use Exception;

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

    public function haveReceitaCreated(string $description): bool
    {
        $response = $this->receitasRepositories->getReceitaBySimpleQuery("descricao", $description);

        $mesAtual = date("m");
        $mesReceita = date('m', strtotime(data_get($response, "0.data")));
        
        if($mesAtual == $mesReceita && !empty($response)){
            throw new Exception("Já existe despesa com mesma descrição dentro do mês");
        }

        return false;
    }
}