<?php

namespace App\Services\Despesas;

use App\Models\Despesas;
use App\Repositories\DespesasRepository;
use Illuminate\Http\Request;

class CreateService
{
    public function __construct(
        private DespesasRepository $despesasRepository,
        private DespesaService $despesaService,
        private Despesas $despesas
    ) {
    }

    public function createDespesa(Request $request)
    {
        $othersCategory = 8;

        $data = [
            "descricao" => $request->descricao,
            "valor" => $request->valor,
            "data" => date('Y-m-d', strtotime($request->data)),
            "categoria_id" => isset($request->categoria_id) ? $request->categoria_id : $othersCategory
        ];

        $this->despesaService->haveDespesaCreated($request->descricao, data_get($data, "data"));

        return $this->despesasRepository->insert($this->despesas, $data);
    }
}
