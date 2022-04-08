<?php

namespace App\Services\Receitas;

use App\Models\Receitas;
use App\Repositories\ReceitasRepositories;
use Exception;

class ReceitasService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories,
        private Receitas $receitas
    ) {
    }

    public function listReceitasInDatabase(?string $filter)
    {
        if (isset($filter)) {
            return $this->receitasRepositories->getDataBySimpleQuery($this->receitas, "descricao", $filter);
        }
        return $this->receitasRepositories->getAllData($this->receitas);
    }

    public function getReceitaById(int $receitaId)
    {
        return $this->receitasRepositories->getDataBySimpleQuery($this->receitas, "id", $receitaId);
    }

    public function haveReceitaCreated(string $description, mixed $data): bool
    {
        $response = $this->receitasRepositories->getDataBySimpleQuery($this->receitas, "descricao", $description);
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
