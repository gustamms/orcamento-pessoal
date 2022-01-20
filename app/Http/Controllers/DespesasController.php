<?php

namespace App\Http\Controllers;

use App\Services\Despesas\CreateService;
use App\Services\Despesas\DespesaService;
use App\Services\Despesas\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class DespesasController extends Controller
{
    public function __construct(
        private CreateService $createService,
        private DespesaService $despesaService,
        private UpdateService $updateService
    ) {
    }

    public function index()
    {
        return $this->despesaService->getDespesas();
    }

    public function show(int $id)
    {
        return $this->despesaService->getById($id);
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
                "Despesa criada com sucesso",
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
        try {
            $this->validate($request, [
                'descricao' => 'required|max:255',
                'valor' => 'required',
                'data' => 'required|date'
            ]);

            $this->updateService->updateDespesa($id, $request);

            return response(
                "Despesa alterada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return response(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $id)
    {
        return $this->despesaService->destroy($id);
    }
}
