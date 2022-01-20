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

    public function haveReceitaCreated(string $description, mixed $data): bool
    {
        $response = $this->receitasRepositories->getReceitaBySimpleQuery("descricao", $description);
        $mesDeInsercao = date("m", strtotime($data));

        foreach ($response as $despesa) {
            $mes = date("m", strtotime(data_get($despesa, "data")));
            if($mes == $mesDeInsercao) {
                throw new Exception("Já existe despesa com mesma descrição dentro do mês");
            }
        }

        return false;
    }
}
