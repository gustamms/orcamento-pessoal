<?php

namespace App\Services\Despesas;

use App\Exceptions\AlreadyExistsInDatabase;
use App\Exceptions\NotFoundException;
use App\Models\Despesas;
use App\Repositories\DespesasRepository;
use Exception;
use Illuminate\Http\Request;

class UpdateService
{
    public function __construct(
        private DespesaService $despesaService,
        private DespesasRepository $despesasRepository,
        private Despesas $despesas
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws AlreadyExistsInDatabase
     * @throws Exception
     */
    public function updateDespesa(int $despesaId, Request $request): bool
    {
        $this->haveDespesaOnDatabase($despesaId);

        $this->despesaService->haveDespesaCreated($request->descricao, $request->data);

        return $this->despesasRepository->update($this->despesas, $despesaId, $request->all());
    }

    private function haveDespesaOnDatabase(int $id)
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, "id", $id);

        if (empty($response)) {
            throw new NotFoundException('Despesa não existe no banco de dados');
        }

        return true;
    }
}
