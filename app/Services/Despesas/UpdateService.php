<?php

namespace App\Services\Despesas;

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

    public function updateDespesa(int $despesaId, Request $request)
    {
        $this->haveDespesaOnDatabase($despesaId);

        $this->despesaService->haveDespesaCreated($request->descricao, $request->data);

        return $this->despesasRepository->update($this->despesas, $despesaId, $request->all());
    }

    private function haveDespesaOnDatabase(int $id)
    {
        $response = $this->despesasRepository->getDataBySimpleQuery($this->despesas, "id", $id);

        if (empty($response)) {
            throw new Exception("Despesa não existe no banco de dados");
        }

        return true;
    }
}
