<?php

namespace App\Services\CategoriasDespesas;

use App\Models\CategoriasDespesas;
use App\Repositories\CategoriasDespesasRepository;

class CategoriasDespesasService
{
    public function __construct(
        private CategoriasDespesasRepository $categoriasDespesasRepository,
        private CategoriasDespesas $categoriasDespesas
    ) {
    }

    public function haveCategoriaWithId(int $id): array
    {
        return $this->categoriasDespesasRepository->getDataBySimpleQuery(
            $this->categoriasDespesas,
            "id",
            $id
        );
    }
}
