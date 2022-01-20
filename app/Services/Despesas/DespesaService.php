<?php

namespace App\Services\Despesas;

use App\Repositories\DespesasRepository;
use Exception;

class DespesaService
{
    public function __construct(
        private DespesasRepository $despesasRepository
    ) {
    }

    public function haveDespesaCreated(string $description, mixed $date): bool
    {
        $response = $this->despesasRepository->getDespesaBySimpleQuery("descricao", $description);
        $mesDeInsercao = date("m", strtotime($date));

        foreach ($response as $despesa) {
            $mes = date("m", strtotime(data_get($despesa, "data")));
            if($mes == $mesDeInsercao) {
                throw new Exception("Já existe despesa com mesma descrição dentro do mês");
            }
        }

        return false;
    }
}
