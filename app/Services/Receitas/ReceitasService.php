<?php

namespace App\Services\Receitas;

use App\Repositories\ReceitasRepositories;

class ReceitasService
{
    public function __construct(
        private ReceitasRepositories $receitasRepositories
    ) {
        
    }

    public function listReceitasInDatabase()
    {
        return $this->receitasRepositories->list();
    }
}