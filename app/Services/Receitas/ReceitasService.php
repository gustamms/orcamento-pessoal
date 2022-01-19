<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;
use Exception;

class ReceitasService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories
    ) {
        
    }

    public function listReceitasInDatabase()
    {
        return $this->receitasRepositories->list();
    }

    public function getReceitaById(int $receitaId)
    {
        return $this->receitasRepositories->getById($receitaId);
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