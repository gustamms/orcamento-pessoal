<?php

namespace App\Services\Receitas;

use App\Models\Receitas;
use App\Repositories\ReceitasRepositories;
use Exception;

class DestroyService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories,
        private Receitas $receitas
    ) {

    }

    public function destroy(int $id)
    {
        $response = $this->receitasRepositories->getDataBySimpleQuery($this->receitas, "id", $id);

        if(empty($response)) {
            throw new Exception("Não foi possível obter dado de receita no banco de dados");
        }

        return $this->receitasRepositories->delete($this->receitas, $id);
    }
}
