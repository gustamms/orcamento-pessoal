<?php

namespace App\Services\Despesas;

use App\Models\Despesas;
use App\Repositories\DespesasRepository;
use Illuminate\Http\Request;

class CreateService
{
    public function __construct(
        private DespesasRepository $despesasRepository,
        private DespesaService $despesaService
    ) {
    }

    public function createDespesa(Request $request)
    {
        $despesa = new Despesas();

        $data = [
            "descricao" => $request->descricao,
            "valor" => $request->valor,
            "data" => date('Y-m-d', strtotime($request->data))
        ];

        $this->despesaService->haveDespesaCreated($request->descricao, data_get($data, "data"));

        return $this->despesasRepository->insert($despesa, $data);
    }
}
