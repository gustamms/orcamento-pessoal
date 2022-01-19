<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;
use Exception;

class DestroyService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories
    ) {
        
    }

    public function destroy(int $id)
    {
        $response = $this->receitasRepositories->getById($id);

        if(empty($response)) {
            throw new Exception("Não foi possível obter dado de receita no banco de dados");
        }

        return $this->receitasRepositories->destroy($id);
    }
}