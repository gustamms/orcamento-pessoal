<?php

namespace App\Http\Controllers;

use App\Services\Receitas\CreateService;
use App\Services\Receitas\DestroyService;
use App\Services\Receitas\ReceitasService;
use App\Services\Receitas\UpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReceitasController extends Controller
{
    public function __construct(
        private CreateService $createService,
        private ReceitasService $receitasService,
        private UpdateService $updateService,
        private DestroyService $destroyService
    ) {

    }

    public function index(Request $request)
    {
        return $this->receitasService->listReceitasInDatabase($request->descricao);
    }

    public function show(int $id)
    {
        return $this->receitasService->getReceitaById($id);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'descricao' => 'required|max:255',
                'valor' => 'required',
                'data' => 'required|date'
            ]);

            $this->createService->createInDatabase($request);

            return response(
                "Receita criada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response(
                $th->getMessage(),
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

            $this->updateService->updateReceita($id, $request);

            return response(
                "Receita alterada com sucesso",
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response(
                $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->destroyService->destroy($id);

            return response(
                "Receita excluída com sucesso",
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response(
                $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
