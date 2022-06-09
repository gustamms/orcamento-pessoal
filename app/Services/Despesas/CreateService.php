<?php

namespace App\Services\Despesas;

use App\Exceptions\NotFoundException;
use App\Models\Despesas;
use App\Repositories\DespesasRepository;
use App\Services\CategoriasDespesas\CategoriasDespesasService;
use Illuminate\Http\Request;

class CreateService
{
    protected const OUTROS_ID = 8;

    public function __construct(
        private DespesasRepository $despesasRepository,
        private DespesaService $despesaService,
        private Despesas $despesas,
        private CategoriasDespesasService $categoriasDespesasService
    ) {
    }

    /**
     * @throws \App\Exceptions\DatabaseException
     * @throws NotFoundException
     */
    public function createDespesa(Request $request): bool
    {
        $categoriaId = $request->categoria_id ?? self::OUTROS_ID;
        $data = [
            "descricao" => $request->descricao,
            "valor" => $request->valor,
            "data" => date('Y-m-d', strtotime($request->data)),
            "categoria_id" => $categoriaId
        ];

        if (empty($this->categoriasDespesasService->haveCategoriaWithId($categoriaId))) {
            throw new NotFoundException('Categoria de despesa não existe');
        }

        $this->despesaService->haveDespesaCreated($request->descricao, data_get($data, "data"));

        return $this->despesasRepository->insert($this->despesas, $data);
    }
}
