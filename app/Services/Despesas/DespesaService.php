<?php

namespace App\Services\Despesas;

use App\Exceptions\AlreadyExistsInDatabase;
use App\Exceptions\NotFoundException;
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

    /**
     * @throws AlreadyExistsInDatabase
     */
    public function haveDespesaCreated(string $description, mixed $date): bool
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, 'descricao', $description);
        $mesDeInsercao = date('m', strtotime($date));

        foreach ($response as $despesa) {
            $mes = date('m', strtotime(data_get($despesa, 'data')));
            if ($mes == $mesDeInsercao) {
                throw new AlreadyExistsInDatabase('Já existe despesa com mesma descrição dentro do mês');
            }
        }

        return false;
    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $id)
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, 'id', $id);
        if (empty($response)) {
            throw new NotFoundException('Não foi possível obter dado de despesa no banco de dados');
        }
        return $response;
    }

    /**
     * @throws NotFoundException
     * @throws \App\Exceptions\DatabaseException
     */
    public function destroy(int $id): bool
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, "id", $id);

        if (empty($response)) {
            throw new NotFoundException('Não foi possível obter dado de despesa no banco de dados');
        }

        return $this->despesasRepository->delete($this->despesas, $id);
    }
}
