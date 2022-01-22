<?php

namespace App\Services\Despesas;

use App\Models\Despesas;
use App\Repositories\DespesasRepository;
use Exception;

class DespesaService
{
    public function __construct(
        private DespesasRepository $despesasRepository,
        private Despesas $despesas
    ) {
    }

    public function getDespesas()
    {
        return $this->despesasRepository->getAllData($this->despesas);
    }

    public function haveDespesaCreated(string $description, mixed $date): bool
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, "descricao", $description);
        $mesDeInsercao = date("m", strtotime($date));

        foreach ($response as $despesa) {
            $mes = date("m", strtotime(data_get($despesa, "data")));
            if($mes == $mesDeInsercao) {
                throw new Exception("Já existe despesa com mesma descrição dentro do mês");
            }
        }

        return false;
    }

    public function getById(int $id)
    {
        return $this->despesasRepository->getDataBySimpleQuery($this->despesas, "id", $id);
    }

    public function destroy(int $id)
    {
        return $this->despesasRepository->delete($this->despesas, $id);
    }
}
