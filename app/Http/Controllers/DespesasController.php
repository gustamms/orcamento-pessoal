<?php

namespace App\Http\Controllers;

use App\Services\Despesas\CreateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class DespesasController extends Controller
{
    public function __construct(
        private CreateService $createService
    ) {
    }

    public function index()
    {
        return 0;
    }

    public function show(int $id)
    {
        return 0;
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'descricao' => 'required|max:255',
                'valor' => 'required',
                'data' => 'required|date'
            ]);

            $this->createService->createDespesa($request);

            return response(
                "Receita criada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function update(int $id, Request $request)
    {
        return 0;
    }

    public function destroy(int $id)
    {
        return 0;
    }
}
